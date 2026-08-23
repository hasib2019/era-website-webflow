<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Handles the two forms the template ships with.
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
