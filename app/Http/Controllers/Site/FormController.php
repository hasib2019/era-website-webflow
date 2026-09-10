<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\JobApplication;
use App\Models\JobOpening;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Handles the site's public forms: contact, newsletter and job applications.
 *
 * The inputs keep the names Webflow gave them so the markup is untouched; they
 * are mapped onto the models here. Webflow's own runtime only takes a form over
 * when it has no `action`, so setting one hands submission back to the browser.
 */
class FormController extends Controller
{
    public function contact(Request $request): RedirectResponse
    {
        if ($response = $this->throttle($request, 'contact', 5)) {
            return $response;
        }

        $data = $request->validateWithBag('contact', [
            'First-name' => ['required', 'string', 'max:100'],
            'Last-name' => ['nullable', 'string', 'max:100'],
            'Email' => ['required', 'email', 'max:255'],
            'Phone-number' => ['nullable', 'string', 'max:40'],
            'Subject' => ['nullable', 'string', 'max:255'],
            'field' => ['required', 'string', 'max:5000'],
        ], [], [
            'First-name' => 'first name',
            'Last-name' => 'last name',
            'Phone-number' => 'phone number',
            'field' => 'message',
        ]);

        ContactMessage::create([
            'name' => trim($data['First-name'] . ' ' . ($data['Last-name'] ?? '')),
            'email' => $data['Email'],
            'phone' => $data['Phone-number'] ?? null,
            'subject' => $data['Subject'] ?? null,
            'message' => $data['field'],
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        return back()
            ->with('form_sent', 'contact')
            ->withFragment('contact-form');
    }

    /**
     * A job application, with the CV attached.
     *
     * The file goes on the `local` disk, which is storage/app/private and is not
     * reachable over the web — a CV is personal data and must not be guessable
     * under /storage. /admin/applications/{id}/resume streams it back to a
     * signed-in admin instead.
     *
     * The upload is stored only after validation passes, so a rejected file is
     * never written, and it is named from a random string rather than what the
     * visitor called it.
     */
    public function apply(Request $request, string $slug): RedirectResponse
    {
        $job = JobOpening::published()->where('slug', $slug)->firstOrFail();

        if ($response = $this->throttle($request, 'apply', 3)) {
            return $response;
        }

        $data = $request->validateWithBag('apply', [
            'Applicant-name' => ['required', 'string', 'max:150'],
            'Applicant-email' => ['required', 'email', 'max:255'],
            'Applicant-phone' => ['required', 'string', 'max:40'],
            'Applicant-note' => ['nullable', 'string', 'max:2000'],
            'Applicant-cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ], [], [
            'Applicant-name' => 'name',
            'Applicant-email' => 'email address',
            'Applicant-phone' => 'phone number',
            'Applicant-note' => 'note',
            'Applicant-cv' => 'CV',
        ]);

        JobApplication::create([
            'job_opening_id' => $job->id,
            'name' => $data['Applicant-name'],
            'email' => $data['Applicant-email'],
            'phone' => $data['Applicant-phone'],
            'cover_letter' => $data['Applicant-note'] ?? null,
            'resume_path' => $request->file('Applicant-cv')->store('applications', 'local'),
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        return back()
            ->with('form_sent', 'apply')
            ->withFragment('apply');
    }

    public function subscribe(Request $request): RedirectResponse
    {
        if ($response = $this->throttle($request, 'subscribe', 5)) {
            return $response;
        }

        $data = $request->validateWithBag('subscribe', [
            'Email' => ['required', 'email', 'max:255'],
        ], [], ['Email' => 'email address']);

        // re-subscribing someone who opted out simply turns them back on
        Subscriber::updateOrCreate(
            ['email' => strtolower($data['Email'])],
            ['is_active' => true, 'source' => 'footer', 'ip_address' => $request->ip()],
        );

        return back()->with('form_sent', 'subscribe');
    }

    /** Keeps a single visitor from flooding the inbox. */
    private function throttle(Request $request, string $key, int $perMinute): ?RedirectResponse
    {
        $bucket = $key . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($bucket, $perMinute)) {
            return back()->with('form_failed', $key);
        }

        RateLimiter::hit($bucket, 60);

        return null;
    }
}
