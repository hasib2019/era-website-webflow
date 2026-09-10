<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    /**
     * Streams an applicant's CV.
     *
     * Uploads live on the `local` disk (storage/app/private), which no URL
     * reaches, so a CV cannot be found by guessing a filename — this route is
     * the only way to it, and it sits behind `applications.view` like the list.
     * The download is named after the applicant rather than the random string
     * the file is stored as.
     */
    public function resume(JobApplication $application): StreamedResponse
    {
        abort_unless($application->resume_path && Storage::disk('local')->exists($application->resume_path), 404);

        $extension = pathinfo($application->resume_path, PATHINFO_EXTENSION);
        $name = str($application->name)->slug()->value() ?: 'applicant';

        return Storage::disk('local')->download(
            $application->resume_path,
            $name . '-cv.' . $extension,
        );
    }
}
