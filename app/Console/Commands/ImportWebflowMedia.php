<?php

namespace App\Console\Commands;

use App\Models\Media;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Registers the assets pulled down from Webflow's CDN into the media library so
 * the dashboard can list, re-use and replace them like any uploaded file.
 *
 * Webflow ships each image with `-p-500`, `-p-800` … downscales; those are folded
 * into the parent row's `variants` instead of appearing as separate entries.
 */
class ImportWebflowMedia extends Command
{
    protected $signature = 'media:import-webflow {--folder=media/webflow}';

    protected $description = 'Register the downloaded Webflow assets in the media library';

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $folder = trim($this->option('folder'), '/');

        $files = collect($disk->files($folder))
            ->reject(fn (string $p) => str_starts_with(basename($p), '.'));

        if ($files->isEmpty()) {
            $this->error("No files under public disk at [$folder].");

            return self::FAILURE;
        }

        // group "name-p-500.webp" under "name.webp"
        $variantOf = [];
        $originals = [];

        foreach ($files as $path) {
            $name = basename($path);
            if (preg_match('/^(.+)-p-(\d+)(\.[A-Za-z0-9]+)$/', $name, $m)) {
                $variantOf[$m[1] . $m[3]][(int) $m[2]] = $path;
            } else {
                $originals[$name] = $path;
            }
        }

        // a downscale whose original is missing still deserves a library row
        foreach ($variantOf as $base => $set) {
            if (! isset($originals[$base])) {
                ksort($set);
                $originals[$base] = end($set);
            }
        }

        $created = 0;
        $skipped = 0;

        foreach ($originals as $name => $path) {
            if (Media::where('disk', 'public')->where('path', $path)->exists()) {
                $skipped++;
                continue;
            }

            $full = $disk->path($path);
            [$width, $height] = $this->dimensions($full);

            Media::create([
                'disk' => 'public',
                'path' => $path,
                'filename' => $name,
                'original_name' => $this->readableName($name),
                'mime_type' => $disk->mimeType($path) ?: null,
                'extension' => pathinfo($name, PATHINFO_EXTENSION),
                'size' => $disk->size($path),
                'width' => $width,
                'height' => $height,
                'alt' => $this->readableName($name),
                'title' => $this->readableName($name),
                'folder' => 'webflow',
                'variants' => $variantOf[$name] ?? null,
            ]);

            $created++;
        }

        $this->info("Imported $created asset(s), skipped $skipped already present.");
        $this->line('Variant groups folded in: ' . count($variantOf));

        return self::SUCCESS;
    }

    /** @return array{0: ?int, 1: ?int} */
    private function dimensions(string $file): array
    {
        $info = @getimagesize($file);

        return $info ? [$info[0], $info[1]] : [null, null];
    }

    /** "664c33abd0e16d4b14b10a0c_Logo.png" -> "Logo" */
    private function readableName(string $filename): string
    {
        $base = pathinfo($filename, PATHINFO_FILENAME);
        $base = preg_replace('/^[0-9a-f]{16,}_/', '', $base);

        return ucfirst(trim(str_replace(['-', '_'], ' ', $base)));
    }
}
