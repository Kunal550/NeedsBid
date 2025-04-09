<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class DocumentController extends Controller
{

    public function doc_create()
    {
        $documents = Auth::user()->documents;

        return view('site.home.upload_doc', compact('documents'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'documents.*' => 'required|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048',
        ]);

        $uploadPath = 'uploads/admin/documents/';

        if (!file_exists(public_path($uploadPath))) {
            mkdir(public_path($uploadPath), 0777, true);
        }

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                $file->move(public_path($uploadPath), $filename);

                // Save each file separately in the database
                Document::create([
                    'user_id' => Auth::id(),
                    'document_type' => $request->document_type,
                    'file_path' => $filename, // Save only the filename
                ]);
            }
        }

        return redirect()->back()->with('success', 'Documents uploaded successfully.');
    }


    public function destroy(Request $request)
    {
        $document = Document::find($request->document_id);

        if (!$document) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        // Delete file from storage
        $filePath = public_path('uploads/admin/documents/' . $document->file_path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Delete from database
        $document->delete();

        return response()->json(['code' => 200, 'msg' => 'Document deleted successfully']);
    }
}
