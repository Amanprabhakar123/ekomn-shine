<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Import;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Jobs\ImportProductJob;
use Illuminate\Support\Str;
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

       $validator = Validator::make($request->all(),[
            'type' => 'required|string|max:100|in:bulk_upload_inventory',
            'import_file' => 'required|file'  
       ]);

       if($validator->fails()){
        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
       }
       $company_id = auth()->user()->companyDetails->id;


       $filename = md5(Str::random(20).time()) . '.' . $request->file('import_file')->getClientOriginalExtension();        
       // Get the file contents
       $fileContents = $request->file('import_file')->get();
       // Define the path
       $path = "import/bulk_upload_inventory/company_{$company_id}/".$filename;
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

        dispatch((new ImportProductJob($importFile->id,$company_id ))->onQueue('product_upload'));

        return response()->json(['success' => true, 'message' => 'File has been queued successfully!']);
    }
}
