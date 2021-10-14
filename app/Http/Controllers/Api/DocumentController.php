<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $role_template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template.docx'));

        $role_template->setValue('name', $request->name);

        try {
            $role_template->saveAs(storage_path($request->name . '.docx'));
        }
        catch (Exception $e) {
            // handle exception
        }
        return response()->download(storage_path($request->name . '.docx'));
    }
}
