<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportErrorMessage;
use Illuminate\Support\Facades\Storage;

class BulkUploadController extends Controller
{
    public function downloadSampleTemplate()
    {
        $filePath = public_path('templates/Bulk-Upload-Template.xlsm'); // Adjust the path to your template file
        $fileName = 'Bulk-Upload-Template_' . uniqid() . '.xlsm'; // Generate a unique file name
        return response()->download($filePath, $fileName);
    }

    /**
     * Get the error messages for the import.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $import = ImportErrorMessage::where('import_id', salt_decrypt($request->import_id))->get();
        if ($import->isNotEmpty()) {
            $data = [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'result' => $import->toArray()
            ];
            return response()->json(['data' => $data], __('statusCode.statusCode200'));
        } else {
            // Handle the case when the import is not found
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' =>  'Import not found'
                ]
            ], __('statusCode.statusCode200'));
        }
    }
}
