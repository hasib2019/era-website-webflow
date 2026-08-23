<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::latest();

        if ($term = trim((string) $request->get('q'))) {
            $query->where('email', 'like', "%{$term}%");
        }

        return view('admin.subscribers.index', [
            'subscribers' => $query->paginate(30)->withQueryString(),
        ]);
    }
}
