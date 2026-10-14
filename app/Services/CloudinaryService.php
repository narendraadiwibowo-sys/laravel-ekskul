<?php

namespace App\Services;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    protected static bool $initialized = false;

    protected static function init(): void
    {
        if (!static::$initialized) {
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => config('services.cloudinary.cloud_name'),
                    'api_key'    => config('services.cloudinary.api_key'),
                    'api_secret' => config('services.cloudinary.api_secret'),
                ],
                'url' => [
                    'secure' => true,
                ],
            ]);
            static::$initialized = true;
        }
    }

    /**
     * Upload an uploaded file or path to Cloudinary.
     * Returns the secure HTTPS URL, or null on failure.
     */
    public static function upload(UploadedFile|string $file, string $folder = 'ekskul'): ?string
    {
        try {
            static::init();

            $uploadApi = new UploadApi();
            $path = $file instanceof UploadedFile ? $file->getRealPath() : $file;

            $result = $uploadApi->upload($path, [
                'folder' => $folder,
                'resource_type' => 'auto',
            ]);

            return $result['secure_url'] ?? null;
        } catch (\Throwable $e) {
            Log::error('Cloudinary upload error: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return null;
        }
    }
}
