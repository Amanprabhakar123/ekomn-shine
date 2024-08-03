<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ImportErrorMessage;
use App\Http\Controllers\Controller;

class BulkUploadController extends Controller
{
    /**
     * Download the sample template file.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Download the error file for the import.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function paymentUpdate(){
         // Check if the user has permission to export payment information
         if (! auth()->user()->hasPermissionTo(User::PERMISSION_PAYMENT_EDIT)) {
           abort(403);
        }
        return view('dashboard.admin.payment-update');
    }

    /**
     * Download the sample template file for payment status.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadSampleTemplatePayment()
    {
        $filePath = public_path('templates/payment-status.csv'); // Adjust the path to your template file
        $fileName = 'payment-status_' . uniqid() . '.csv'; // Generate a unique file name
        return response()->download($filePath, $fileName);
    }
}
