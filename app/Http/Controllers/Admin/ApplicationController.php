<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with('jobOpening')->latest();

        if ($term = trim((string) $request->get('q'))) {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%"));
        }

        return view('admin.applications.index', [
            'applications' => $query->paginate(20)->withQueryString(),
        ]);
    }
}
