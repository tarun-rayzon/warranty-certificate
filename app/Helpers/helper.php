<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

if (! function_exists('optimize_and_upload_image')) {
    /**
     * Optimize and upload image to S3 (or any disk).
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $fileName
     * @param string $disk
     * @return string Full path of stored image on the disk
     */
    function optimize_and_upload_image(UploadedFile $file, string $directory, string $fileName = '', string $disk = 's3', string $deletePath = ''): string
    {
        if ($deletePath && Storage::disk($disk)->exists($deletePath)) {
            Storage::disk($disk)->delete($deletePath);
        }

        // Generate a file name if not provided
        $fileName = $fileName ?: time() . '.' . $file->getClientOriginalExtension();

        // Create temporary local path
        $tempPath = storage_path('app/tmp_' . $fileName);
        $file->move(dirname($tempPath), basename($tempPath));

        // Upload to disk
        $diskPath = trim($directory, '/') . '/' . $fileName;
        Storage::disk($disk)->put($diskPath, file_get_contents($tempPath), 'public');

        // Clean up
        @unlink($tempPath);

        return $diskPath;
    }
}
