<?php

namespace App\Services;

use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminAuthService
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepository
    ) {}

    /**
     * Attempt to authenticate an admin.
     *
     * @throws ValidationException
     */
    public function login(string $email, string $password, bool $remember, string $ip): void
    {
        $this->ensureNotRateLimited($email, $ip);

        $admin = $this->adminRepository->findByEmail($email);

        if (! $admin || ! Hash::check($password, $admin->password)) {
            RateLimiter::hit($this->throttleKey($email, $ip), 60);

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        if (! $admin->is_active) {
            throw ValidationException::withMessages([
                'email' => __('Your account has been deactivated. Please contact support.'),
            ]);
        }

        Auth::guard('admin')->login($admin, $remember);

        RateLimiter::clear($this->throttleKey($email, $ip));

        $this->adminRepository->updateLastLogin($admin->id, $ip);
    }

    /**
     * Log out the currently authenticated admin.
     */
    public function logout(): void
    {
        Auth::guard('admin')->logout();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    protected function ensureNotRateLimited(string $email, string $ip): void
    {
        $key = $this->throttleKey($email, $ip);

        if (! RateLimiter::tooManyAttempts($key, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(string $email, string $ip): string
    {
        return Str::transliterate(Str::lower($email) . '|' . $ip);
    }
}