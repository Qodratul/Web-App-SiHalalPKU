<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\UploadedFile;
use Exception;

class CloudinaryService
{
    protected Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);
    }

    /**
     * Upload image to Cloudinary.
     *
     * @param mixed $file
     * @param string $folder
     * @return string URL of uploaded image
     * @throws Exception
     */
    public function uploadImage($file, string $folder = 'umkm'): string
    {
        try {
            // Check if file is valid UploadedFile
            if (!$file instanceof UploadedFile) {
                throw new Exception('File bukan UploadedFile yang valid');
            }

            if (!$file->isValid()) {
                throw new Exception('File tidak valid: ' . $file->getErrorMessage());
            }

            // Upload using Cloudinary SDK
            $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => "web-map-umkm-halal/{$folder}",
                'resource_type' => 'image',
            ]);

            $url = $result['secure_url'] ?? null;
            
            if (empty($url)) {
                throw new Exception('URL gambar kosong setelah upload');
            }

            return $url;
        } catch (Exception $e) {
            throw new Exception('Gagal mengupload gambar: ' . $e->getMessage());
        }
    }

    /**
     * Delete image from Cloudinary.
     *
     * @param string $url
     * @return bool
     */
    public function deleteImage(string $url): bool
    {
        try {
            // Extract public_id from URL
            $publicId = $this->extractPublicId($url);
            
            if ($publicId) {
                $this->cloudinary->uploadApi()->destroy($publicId);
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            // Log error but don't throw exception
            return false;
        }
    }

    /**
     * Extract public_id from Cloudinary URL.
     *
     * @param string $url
     * @return string|null
     */
    private function extractPublicId(string $url): ?string
    {
        // Cloudinary URL format: https://res.cloudinary.com/{cloud_name}/image/upload/v{version}/{public_id}.{format}
        // We need to extract the public_id
        
        if (empty($url) || !str_contains($url, 'cloudinary.com')) {
            return null;
        }

        // Match pattern: /upload/v{version}/{public_id}
        if (preg_match('/\/upload\/(?:v\d+\/)?(.+)\.[a-z]+$/i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Check if URL is a Cloudinary URL.
     *
     * @param string $url
     * @return bool
     */
    public function isCloudinaryUrl(string $url): bool
    {
        return str_contains($url, 'cloudinary.com');
    }
}
