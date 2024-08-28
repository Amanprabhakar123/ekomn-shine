<?php
namespace App\Transformers;
use App\Models\User;
use App\Models\Import;
use League\Fractal\TransformerAbstract;

class BulkDataTransformer extends TransformerAbstract
{
    /**
     * Transform the given Import model into a formatted array.
     *
     * @param  Import  $import
     * @return array
     */
    public function transform(Import $import)
    {
        try {
            $data = [
                'id' => salt_encrypt($import->id),
                'type' => $import->type,
                'filename' => $import->filename,
                'file_type' => $import->file_type,
                'file_path' => 'storage/' . $import->file_path ,
                'status' => $import->status,
                'success_count' => $import->success_count,
                'fail_count' => $import->fail_count,
                'error_file' => $import->error_file,
                'created_at' => $import->created_at->toDateTimeString(),
                'updated_at' => $import->updated_at->toDateTimeString(),
            ];

            if(auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN)){
                $data['company_id'] = salt_encrypt($import->company_id);
            }
            return $data;
        } catch (\Exception $e) {
            // Handle the exception here
            // You can log the error, return a default value, or throw a custom exception
            // For example, you can log the error and return an empty array
            \Log::error('Error transforming Import: ' . $e->getMessage());
            return [];
        }
    }
}