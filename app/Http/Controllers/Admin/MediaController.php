<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /** Image, video, and document types the library accepts. */
    private const MIMES = 'jpg,jpeg,png,gif,webp,avif,svg,mp4,webm,ogg,pdf';

    public function index(Request $request)
    {
        $query = Media::query()->latest('id');

        if ($folder = $request->get('folder')) {
            $query->where('folder', $folder);
        }

        if ($term = trim((string) $request->get('q'))) {
            $query->where(function ($q) use ($term) {
                $q->where('original_name', 'like', "%{$term}%")
                    ->orWhere('filename', 'like', "%{$term}%")
                    ->orWhere('alt', 'like', "%{$term}%");
            });
        }

        return view('admin.media.index', [
            'files' => $query->paginate(36)->withQueryString(),
            'folders' => Media::query()->distinct()->orderBy('folder')->pluck('folder'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'files' => ['required', 'array', 'max:20'],
            'files.*' => ['file', 'mimes:' . self::MIMES, 'max:20480'],
            'folder' => ['nullable', 'string', 'max:60'],
        ]);

        $folder = Str::slug($request->input('folder') ?: 'uploads') ?: 'uploads';
        $count = 0;

        foreach ($request->file('files') as $file) {
            $filename = $this->uniqueFilename($folder, $file->getClientOriginalName());
            $path = $file->storeAs("media/{$folder}", $filename, 'public');

            [$width, $height] = $this->dimensions(Storage::disk('public')->path($path));

            $media = Media::create([
                'disk' => 'public',
                'path' => $path,
                'filename' => $filename,
                'original_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'mime_type' => $file->getClientMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'width' => $width,
                'height' => $height,
                'alt' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'folder' => $folder,
                'uploaded_by' => $request->user()->id,
            ]);

            ActivityLogger::log('uploaded', $media, 'Uploaded ' . $media->filename);
            $count++;
        }

        return back()->with('success', $count . ' file(s) uploaded.');
    }

    public function update(Request $request, Media $medium): RedirectResponse
    {
        $data = $request->validate([
            'alt' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        $medium->update($data);
        ActivityLogger::log('updated', $medium, 'Updated media details: ' . $medium->filename);

        return back()->with('success', 'Media details saved.');
    }

    public function destroy(Media $medium): RedirectResponse
    {
        $disk = Storage::disk($medium->disk);
        $disk->delete($medium->path);

        foreach ((array) $medium->variants as $variant) {
            $disk->delete($variant);
        }

        ActivityLogger::log('deleted', $medium, 'Deleted media: ' . $medium->filename);
        $medium->delete();

        return back()->with('success', 'File deleted.');
    }

    private function uniqueFilename(string $folder, string $original): string
    {
        $name = Str::slug(pathinfo($original, PATHINFO_FILENAME)) ?: 'file';
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $candidate = $name . '.' . $ext;
        $n = 2;

        while (Storage::disk('public')->exists("media/{$folder}/{$candidate}")) {
            $candidate = $name . '-' . $n++ . '.' . $ext;
        }

        return $candidate;
    }

    /** @return array{0: ?int, 1: ?int} */
    private function dimensions(string $file): array
    {
        $info = @getimagesize($file);

        return $info ? [$info[0], $info[1]] : [null, null];
    }
}
