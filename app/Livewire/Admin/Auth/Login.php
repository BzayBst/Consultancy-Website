<?php

namespace App\Livewire\Admin\Auth;

use App\Services\AdminAuthService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('admin.layouts.auth')]
#[Title('Admin Login – HASU')]
class Login extends Component
{
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required|min:6')]
    public string $password = '';

    public bool $remember = false;

    public function mount(): void
    {
        // Redirect already-authenticated admins
        if (auth('admin')->check()) {
            $this->redirectRoute('admin.dashboard', navigate: true);
        }
    }

    public function login(AdminAuthService $authService): void
    {
        $this->validate();

        try {
            $authService->login(
                email: $this->email,
                password: $this->password,
                remember: $this->remember,
                ip: request()->ip(),
            );

            session()->regenerate();

            $this->redirectRoute('admin.dashboard', navigate: true);

        } catch (ValidationException $e) {
            // Map service-level validation errors back to component fields
            foreach ($e->errors() as $field => $messages) {
                $this->addError($field, $messages[0]);
            }

            // Clear password field on failure for security
            $this->reset('password');
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.auth.login');
    }
}