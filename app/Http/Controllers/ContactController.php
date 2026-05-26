<?php

namespace App\Http\Controllers;

use App\Models\AppointmentPage;
use App\Models\AppointmentSubmission;
use App\Models\ContactPage;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function contact()
    {
        return view('pages.contact', [
            'contactPage' => ContactPage::first(),
        ]);
    }

    public function submitContact(Request $request)
    {
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
        ]);
    }

    public function submitAppointment(Request $request)
    {
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
}
