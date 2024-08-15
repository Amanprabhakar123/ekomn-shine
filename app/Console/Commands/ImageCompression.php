<?php

namespace App\Console\Commands;

use App\Events\ExceptionEvent;
use App\Models\ProductVariationMedia;
use App\Services\ImageService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageCompression extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:compression';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compresses images and creates thumbnails for product variations.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        parent::__construct();
        $this->imageService = $imageService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $start = microtime(true);
            $this->info('Image Compression started at: '.now());
            $this->fetchAndCompressSameVariantImages();

            $end = microtime(true);
            $executionTime = round($end - $start, 2);
            $this->info('Image Compression. Total execution time: '.$executionTime.' seconds.');
        } catch (\Exception $e) {
            // Handle the exception here
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            Log::error($e->getMessage(), $e->getTrace(), $e->getLine());
        }

    }

    /**
     * Fetches and compresses all images.
     *
     * @return void
     *
     * @throws Exception
     */
    private function fetchAndCompressAllImages()
    {
        try {
            // Your code here
            $imagePaths = ProductVariationMedia::where(['is_compressed' => ProductVariationMedia::IS_COMPRESSED_FALSE, 'media_type' => ProductVariationMedia::MEDIA_TYPE_IMAGE])->get();
            if ($imagePaths->isEmpty()) {
                $this->info('No images found for compression.');

                return;
            }
            $allowedExtensions = ['png', 'jpeg', 'jpg', 'PNG', 'JPEG', 'JPG'];
            foreach ($imagePaths as $image) {
                $originalPath = $image->file_path;

                $this->info($image->id);

                // Get the file extension
                $fileInfo = pathinfo($image->file_path);
                $fileExtension = isset($fileInfo['extension']) ? $fileInfo['extension'] : '';

                if (! in_array(strtolower($fileExtension), $allowedExtensions)) {
                    $this->info('Invalid file extension: '.$fileExtension);
                    ProductVariationMedia::where('id', $image->id)->update([
                        'is_compressed' => ProductVariationMedia::IS_COMPRESSED_TRUE,
                    ]);

                    continue;
                }

                $originalPath = str_replace('storage/', '', $image->file_path);
                $orignalThumbnailPath = str_replace('storage/', '', $image->thumbnail_path);

                // Verify the original path and adjust if needed
                $originalFullPath = storage_path('app/public/'.$originalPath);
                if (! File::exists($originalFullPath)) {
                    Log::info('Original image not found at path: '.$originalFullPath);
                    $this->info('Original image not found at path: '.$originalFullPath);

                    continue;
                }

                $filename = Str::random(40).'.webp';
                $thumbnail_file_name = Str::random(40).'.webp';
                $destinationPath = "company_{$image->product->company_id}/".$image->product_id."/images/{$filename}";
                $thumbnailPath = "company_{$image->product->company_id}/".$image->product_id.'/images/thumbnails/'.$thumbnail_file_name;

                // Convert and compress image to WebP format
                $this->imageService->convertAndCompressToWebP($originalFullPath, $destinationPath);

                // Create e-commerce standard thumbnail
                $this->imageService->createEcommerceThumbnail($originalFullPath, $thumbnailPath);

                // Remove the original file
                if (File::exists($originalFullPath)) {
                    // $this->info($originalFullPath);
                    File::delete($originalFullPath);
                }

                if (File::exists($orignalThumbnailPath) && ! empty($orignalThumbnailPath)) {
                    // $this->info($originalFullPath);
                    File::delete($orignalThumbnailPath);
                }

                $this->line($thumbnailPath);

                $image->update([
                    'is_compressed' => ProductVariationMedia::IS_COMPRESSED_TRUE,
                    'file_path' => Storage::url($destinationPath),
                    'thumbnail_path' => Storage::url($thumbnailPath),
                ]);
            }
        } catch (Exception $e) {
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Fetches and compresses images that have the same variant.
     *
     * @return void
     *
     * @throws Exception
     */
    private function fetchAndCompressSameVariantImages()
    {
        try {
            // Your code here
            $imagePaths = ProductVariationMedia::where(['is_compressed' => ProductVariationMedia::IS_COMPRESSED_FALSE, 'media_type' => ProductVariationMedia::MEDIA_TYPE_IMAGE])
                ->groupBy('file_path')
                ->get();
            if ($imagePaths->isEmpty()) {
                $this->info('No images found for compression.');

                return;
            }

            $allowedExtensions = ['png', 'jpeg', 'jpg', 'webp', 'PNG', 'JPEG', 'JPG', 'WEBP'];
            foreach ($imagePaths as $image) {

                $this->info($image->id);
                // Get the file extension
                $fileInfo = pathinfo($image->file_path);
                $fileExtension = isset($fileInfo['extension']) ? $fileInfo['extension'] : '';

                if (! in_array(strtolower($fileExtension), $allowedExtensions)) {
                    $this->info('Invalid file extension: '.$fileExtension);
                    ProductVariationMedia::where('id', $image->id)->update([
                        'is_compressed' => ProductVariationMedia::IS_COMPRESSED_TRUE,
                    ]);

                    continue;
                }

                $originalPath = $image->file_path;

                $this->info($image->id);
                $originalPath = str_replace('storage/', '', $image->file_path);
                $orignalThumbnailPath = str_replace('storage/', '', $image->thumbnail_path);

                // Verify the original path and adjust if needed
                $originalFullPath = storage_path('app/public/'.$originalPath);
                if (! File::exists($originalFullPath)) {
                    $this->info('Original image not found at path: '.$originalFullPath);

                    continue;
                }

                $filename = Str::random(40).'.webp';
                $thumbnail_file_name = Str::random(40).'.webp';
                $destinationPath = "company_{$image->product->company_id}/".$image->product_id."/images/{$filename}";
                $thumbnailPath = "company_{$image->product->company_id}/".$image->product_id.'/images/thumbnails/'.$thumbnail_file_name;

                // Convert and compress image to WebP format
                $this->imageService->convertAndCompressToWebP($originalFullPath, $destinationPath);

                // Create e-commerce standard thumbnail
                $this->imageService->createEcommerceThumbnail($originalFullPath, $thumbnailPath);

                // Remove the original file
                if (File::exists($originalFullPath)) {
                    // $this->info($originalFullPath);
                    File::delete($originalFullPath);
                }

                if (File::exists($orignalThumbnailPath) && ! empty($orignalThumbnailPath)) {
                    // $this->info($originalFullPath);
                    File::delete($orignalThumbnailPath);
                }

                $this->line($thumbnailPath);

                ProductVariationMedia::where('file_path', $originalPath)->update([
                    'is_compressed' => ProductVariationMedia::IS_COMPRESSED_TRUE,
                    'file_path' => Storage::url($destinationPath),
                    'thumbnail_path' => Storage::url($thumbnailPath),
                ]);
            }
        } catch (Exception $e) {
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
