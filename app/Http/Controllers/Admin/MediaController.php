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

    /** Every upload lands flat in the disk root, which is public/era. */
    private const FOLDER = 'era';

    /** PHP's own max_file_uploads is the real ceiling; stay at or under it. */
    private const MAX_FILES = 20;

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
            'maxUploadMb' => (int) floor(self::maxKilobytes() / 1024),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'files' => ['required', 'array', 'max:' . self::MAX_FILES],
            'files.*' => ['file', 'mimes:' . self::MIMES, 'max:' . self::maxKilobytes()],
        ]);

        $disk = Storage::disk('public');
        $uploaded = 0;
        $failed = [];

        foreach ($request->file('files') as $file) {
            $filename = $this->uniqueFilename($file->getClientOriginalName());

            // Straight into the disk root -- public/era, no nesting.
            if (! $file->storeAs('', $filename, 'public')) {
                $failed[] = $file->getClientOriginalName();
                continue;
            }

            $full = $disk->path($filename);
            [$width, $height] = $this->dimensions($full);

            $media = Media::create([
                'disk' => 'public',
                'path' => $filename,
                'filename' => $filename,
                'original_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                /*
                 * Sniffed from the stored bytes, not taken from the upload.
                 *
                 * Browsers read the type off the Windows registry and hand us
                 * application/octet-stream for webp, avif and svg often enough
                 * that trusting them left is_image false -- the grid then drew
                 * the extension placeholder over a perfectly good image and the
                 * upload read as failed.
                 */
                'mime_type' => $disk->mimeType($filename) ?: $file->getClientMimeType(),
                'extension' => strtolower(pathinfo($filename, PATHINFO_EXTENSION)),
                'size' => $disk->size($filename),
                'width' => $width,
                'height' => $height,
                'alt' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'folder' => self::FOLDER,
                'uploaded_by' => $request->user()->id,
            ]);

            ActivityLogger::log('uploaded', $media, 'Uploaded ' . $media->filename);
            $uploaded++;
        }

        if ($failed) {
            return back()
                ->with('error', 'Could not save: ' . implode(', ', $failed))
                ->with('success', $uploaded ? $uploaded . ' file(s) uploaded.' : null);
        }

        return back()->with('success', $uploaded . ' file(s) uploaded.');
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

    /**
     * A free name in the disk root.
     *
     * Checked against the library table as well as the disk: `media` has a
     * unique index on (disk, path), so a row whose file was removed by hand
     * still owns that name. Only looking at the filesystem let the insert hit
     * a 1062 mid-loop, which aborted the request with some files already
     * written and nothing explaining why.
     */
    private function uniqueFilename(string $original): string
    {
        $name = Str::slug(pathinfo($original, PATHINFO_FILENAME)) ?: 'file';
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $candidate = $name . '.' . $ext;
        $n = 2;

        while ($this->taken($candidate)) {
            $candidate = $name . '-' . $n++ . '.' . $ext;
        }

        return $candidate;
    }

    private function taken(string $filename): bool
    {
        return Storage::disk('public')->exists($filename)
            || Media::where('disk', 'public')->where('path', $filename)->exists();
    }

    /**
     * The per-file cap in kilobytes, clamped to what PHP will actually accept.
     *
     * Advertising 20 MB while php.ini caps uploads lower means the file is
     * dropped before Laravel sees it, and the user gets "files is required"
     * on a form they plainly filled in.
     */
    private static function maxKilobytes(): int
    {
        $ini = min(
            self::iniBytes('upload_max_filesize'),
            self::iniBytes('post_max_size'),
        );

        return (int) max(1, min(20480, intdiv($ini, 1024)));
    }

    private static function iniBytes(string $key): int
    {
        $value = trim((string) ini_get($key));

        if ($value === '') {
            return PHP_INT_MAX;
        }

        $bytes = (int) $value;

        return match (strtolower(substr($value, -1))) {
            'g' => $bytes * 1024 ** 3,
            'm' => $bytes * 1024 ** 2,
            'k' => $bytes * 1024,
            default => $bytes,
        };
    }

    /** @return array{0: ?int, 1: ?int} */
    private function dimensions(string $file): array
    {
        $info = @getimagesize($file);

        return $info ? [$info[0], $info[1]] : [null, null];
    }
}
