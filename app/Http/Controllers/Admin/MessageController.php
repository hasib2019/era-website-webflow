<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($term = trim((string) $request->get('q'))) {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('message', 'like', "%{$term}%"));
        }

        return view('admin.messages.index', [
            'messages' => $query->paginate(20)->withQueryString(),
            'counts' => ContactMessage::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function show(ContactMessage $message)
    {
        // opening an unread message marks it read
        if ($message->status === 'new') {
            $message->update(['status' => 'read']);
        }

        return view('admin.messages.show', ['message' => $message]);
    }

    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,read,replied,archived'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $message->update($data);
        ActivityLogger::log('updated', $message, 'Updated message from ' . $message->email);

        return back()->with('success', 'Message updated.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        ActivityLogger::log('deleted', $message, 'Deleted message from ' . $message->email);
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
