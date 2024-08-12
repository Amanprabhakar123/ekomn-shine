<?php

namespace App\Services;

use Tinify\Source;
use Tinify\Tinify;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function __construct()
    {
        // Set the API key
        Tinify::setKey(config('services.tinify.key'));
    }

   /**
     * Convert an image to WebP format and compress it.
     * @param string $sourcePath
     * @param string $destinationPath
     * @return void
     * @throws \Exception
     */
    public function convertAndCompressToWebP($sourcePath, $destinationPath, $thumbWidth = 800, $thumbHeight = 800)
    {
        $source = Source::fromFile($sourcePath);
        $webpPath = preg_replace('/\.(jpg|jpeg|png|webp)$/i', '.webp', $destinationPath);

        // Resize the image
        $thumbnail = $source->resize([
            'method' => 'fit',
            'width' => $thumbWidth,
            'height' => $thumbHeight
        ]);

        $converted = $thumbnail->convert(['type' => 'image/webp']);
        $compressedContent = $converted->toBuffer();
        Storage::disk('public')->put($webpPath, $compressedContent);
    }

    /**
     * Create a thumbnail in WebP format according to e-commerce standards.
     * @param string $sourcePath
     * @param string $thumbnailPath
     * @param int $thumbWidth
     * @param int $thumbHeight
     * @return void
     */
    public function createEcommerceThumbnail($sourcePath, $thumbnailPath, $thumbWidth = 200, $thumbHeight = 200)
    {
        $source = Source::fromFile($sourcePath);
        $thumbnailWebPPath = preg_replace('/\.(jpg|jpeg|png|webp)$/i', '.webp', $thumbnailPath);

        // Resize the image
        $thumbnail = $source->resize([
            'method' => 'fit',
            'width' => $thumbWidth,
            'height' => $thumbHeight
        ]);

        // Convert the resized image to WebP
        $converted = $thumbnail->convert(['type' => 'image/webp']);
        $thumbnailContent = $converted->toBuffer();

        // Save the converted WebP image to the public disk
        Storage::disk('public')->put($thumbnailWebPPath, $thumbnailContent);
    }
}
