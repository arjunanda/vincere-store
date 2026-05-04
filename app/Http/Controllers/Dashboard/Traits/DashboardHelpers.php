<?php

namespace App\Http\Controllers\Dashboard\Traits;

trait DashboardHelpers
{
    protected function logActivity($action, $description)
    {
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }

    protected function uploadAndCompressImage($file, $directory)
    {
        $filename = \Illuminate\Support\Str::random(20) . '.webp';
        $fullDirectoryPath = storage_path('app/public/' . $directory);
        $path = $directory . '/' . $filename;

        // Ensure directory exists
        if (!file_exists($fullDirectoryPath)) {
            mkdir($fullDirectoryPath, 0775, true);
            // Ensure permissions are set correctly even if parent exists
            chmod($fullDirectoryPath, 0775);
        }

        // Use Intervention Image (v4) to process and convert to WebP
        \Illuminate\Support\Facades\Log::info("Uploading image to: " . $path);
        
        \Intervention\Image\Laravel\Facades\Image::decode($file)
            ->encodeUsingFileExtension('webp', quality: 80)
            ->save(storage_path('app/public/' . $path));
            
        return $path;
    }
}
