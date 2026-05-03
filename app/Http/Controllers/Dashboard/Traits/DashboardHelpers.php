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
        $path = $directory . '/' . $filename;

        // Use Intervention Image (v4) to process and convert to WebP
        \Intervention\Image\Laravel\Facades\Image::decode($file)
            ->encodeUsingFileExtension('webp', quality: 80)
            ->save(storage_path('app/public/' . $path));
        return $path;
    }
}
