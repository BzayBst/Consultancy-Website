<?php

namespace App\Http\Controllers;

use App\Models\AppointmentPage;
use App\Models\AppointmentSubmission;
use App\Models\BranchOffice;
use App\Models\ContactFaq;
use App\Models\ContactPage;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function contact()
    {
        return view('pages.contact', [
            'contactPage' => ContactPage::first(),
            'headOffice' => $this->headOffice(),
            'branchOffices' => BranchOffice::active()->ordered()->get()->map(fn (BranchOffice $branch) => $this->branchPayload($branch))->values(),
            'contactFaqs' => ContactFaq::active()->ordered()->get(),
        ]);
    }

    public function submitContact(Request $request)
    {
        $this->guardAgainstBotSubmission($request);

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:60'],
            'destination' => ['nullable', 'string', 'max:120'],
            'service' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:2000'],
            'consent' => ['accepted'],
        ]);

        unset($data['consent']);
        ContactSubmission::create($data);

        return back()->with('contact_success', 'Your message has been sent. We will get back to you within 24 hours.');
    }

    public function appointment()
    {
        return view('pages.book-appointment', [
            'appointmentPage' => AppointmentPage::first(),
            'headOffice' => $this->headOffice(),
            'branchOffices' => BranchOffice::active()->ordered()->get()->map(fn (BranchOffice $branch) => $this->branchPayload($branch))->values(),
            'bookedSlots' => $this->bookedAppointmentSlots(),
        ]);
    }

    public function submitAppointment(Request $request)
    {
        $this->guardAgainstBotSubmission($request);

        $data = $request->validate([
            'branch' => ['required', 'string', 'max:160'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'string', 'max:40'],
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:60'],
            'education' => ['nullable', 'string', 'max:120'],
            'destination' => ['nullable', 'string', 'max:120'],
            'service' => ['nullable', 'string', 'max:160'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
        ]);

        unset($data['consent']);

        $alreadyBooked = AppointmentSubmission::query()
            ->where('branch', $data['branch'])
            ->whereDate('appointment_date', $data['appointment_date'])
            ->where('appointment_time', $data['appointment_time'])
            ->exists();

        if ($alreadyBooked) {
            $message = 'That time slot has just been booked. Please choose another time.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->withErrors(['appointment_time' => $message])->withInput();
        }

        $data['reference'] = 'HASU-' . now()->format('ymd') . '-' . Str::upper(Str::random(4));

        $appointment = AppointmentSubmission::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Appointment booked successfully.',
                'reference' => $appointment->reference,
            ]);
        }

        return back()->with('appointment_success', 'Your appointment has been booked. Reference: ' . $appointment->reference);
    }

    private function headOffice(): array
    {
        $phones = collect([
            setting('contact_phone_landline'),
            setting('contact_phone_primary'),
            setting('contact_phone_secondary'),
        ])->filter()->values();

        $email = setting('contact_email_primary', 'info@hasuedu.com');
        $address = setting('contact_address', 'Birendra Campus Gate, Bhairahawa-11, Rupandehi, Nepal');
        $mapUrl = $this->mapSrc(setting('contact_map_embed'));

        return [
            'name' => 'Head Office',
            'type' => 'hq',
            'location_label' => $this->locationLabel($address),
            'address' => $address,
            'phone' => $phones->implode(' | '),
            'phone_href' => $this->telHref($phones->first()),
            'email' => $email,
            'weekday_hours' => 'Sun-Fri 9AM-5PM',
            'saturday_hours' => 'Sat 10AM-3PM',
            'map_embed_url' => $mapUrl,
            'map_link_url' => $mapUrl,
        ];
    }

    private function guardAgainstBotSubmission(Request $request): void
    {
        $startedAt = (int) $request->input('form_started_at', 0);
        $elapsed = now()->timestamp - $startedAt;

        if (
            filled($request->input('company_website'))
            || $startedAt <= 0
            || $elapsed < 3
            || $elapsed > 60 * 60 * 4
        ) {
            throw ValidationException::withMessages([
                'form' => 'Please wait a moment and try submitting the form again.',
            ]);
        }
    }

    private function branchPayload(BranchOffice $branch): array
    {
        return [
            'name' => $branch->name,
            'type' => 'branch',
            'location_label' => $branch->location_label ?: $this->locationLabel($branch->address),
            'address' => $branch->address,
            'phone' => $branch->phone,
            'phone_href' => $this->telHref($branch->phone),
            'email' => $branch->email,
            'weekday_hours' => $branch->weekday_hours,
            'saturday_hours' => $branch->saturday_hours,
            'map_embed_url' => $this->mapSrc($branch->map_embed_url),
            'map_link_url' => $branch->map_link_url ?: $branch->map_embed_url,
        ];
    }

    private function bookedAppointmentSlots(): array
    {
        return AppointmentSubmission::query()
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->get(['branch', 'appointment_date', 'appointment_time'])
            ->groupBy(fn (AppointmentSubmission $item) => $item->branch.'|'.$item->appointment_date->format('Y-m-d'))
            ->map(fn ($items) => $items->pluck('appointment_time')->values())
            ->toArray();
    }

    private function mapSrc(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        if (preg_match('/src=["\']([^"\']+)["\']/', $value, $matches)) {
            return $matches[1];
        }

        return $value;
    }

    private function telHref(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        $first = preg_split('/[|,\/]/', $value)[0] ?? $value;
        $number = preg_replace('/[^+\d]/', '', $first);

        return $number ?: null;
    }

    private function locationLabel(?string $address): ?string
    {
        if (! $address) {
            return null;
        }

        return trim(collect(explode(',', $address))->take(-2)->implode(', '));
    }
}
