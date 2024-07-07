<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Import;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'type' => 'required|string|max:100',
            'import_file' => 'required|file'
        ]);

        $file = $request->file('import_file');
        $filename = $file->getClientOriginalName();
        $fileType = $file->getClientOriginalExtension();
        $filePath = $file->store('imports');

        $importFile = Import::create([
            'type' => $request->input('type'),
            'filename' => $filename,
            'file_type' => $fileType,
            'file_path' => $filePath,
            'company_id' => $request->input('company_id'),
        ]);

        $fileContent = file_get_contents($file->getRealPath());
        return response()->json(['message' => 'File imported successfully!']);
    }
}
