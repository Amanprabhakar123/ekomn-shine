<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BulkUploadController extends Controller
{
    public function downloadSampleTemplate()
    {
        $filePath = public_path('templates/bulk_upload_template.xlsx'); // Adjust the path to your template file
        return response()->download($filePath, 'bulk_upload_template.xlsx');
    }

}
