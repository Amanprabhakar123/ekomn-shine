<?php

namespace App\Http\Controllers\Import;

use App\Models\User;
use App\Models\Import;
use App\Models\QueueName;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Jobs\ImportProductJob;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImportController extends Controller
{
    /**
     * Handle file import.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function importFile(Request $request)
    {

        if (auth()->user()->hasRole(User::ROLE_SUPPLIER) || auth()->user()->hasPermissionTo(User::PERMISSION_ADD_PRODUCT)) {
            if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
                $validator = Validator::make($request->all(), [
                    'import_file' => 'required|file|mimes:xls,xlsx,xlsm|max:4096',
                ]);
            } else if (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                $validator = Validator::make($request->all(), [
                    'import_file' => 'required|file|mimes:xls,xlsx,xlsm|max:4096',
                    'supplier_id' => 'required|string',
                ]);
            }
            $request->merge(['type' => Import::TYPE_BULK_UPLOAD_INVENTORY]);
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors(),
                ]], __('statusCode.statusCode200'));
            }

            if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
                $company_id = auth()->user()->companyDetails->id;
            } else if (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                $company_detail = CompanyDetail::where('company_serial_id', $request->supplier_id)->first();
                if(!$company_detail) {
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => __('auth.supplierNotFound'),
                    ]], __('statusCode.statusCode200'));
                }
                $company_id = $company_detail->id ?? null;
            }

            $filename = md5(Str::random(20) . time()) . '.' . $request->file('import_file')->getClientOriginalExtension();
            // Get the file contents
            $fileContents = $request->file('import_file')->get();
            // Define the path
            $path = "import/bulk_upload_inventory/company_{$company_id}/" . $filename;
            // Store the file
            Storage::disk('public')->put($path, $fileContents);

            $file = $request->file('import_file');
            $filename = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
            $importFile = Import::create([
                'type' => $request->type,
                'filename' => $filename,
                'file_type' => $fileType,
                'file_path' => $path,
                'company_id' => $company_id,
                'status' => Import::STATUS_PENDING
            ]);

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.importSuccess'),
            ]], __('statusCode.statusCode200'));
        } else {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode403'),
                'status' => __('statusCode.status403'),
                'message' => __('auth.status403'),
            ]], __('statusCode.statusCode200'));
        }
    }
}
