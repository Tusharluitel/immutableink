<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $files = File::where('user_id',$user->id)->latest()->paginate(10);

        return view('dashboard.home',compact('files'));
    }

    public function create()
    {
        return view('dashboard.create');
    }
    public function store(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:jpg,png,pdf,docx,mp3,wav,mp4,mov,avi|max:51200',
        'link' => 'required|url|unique:files,link',
    ]);

    if ($request->hasFile('file')) {
        $uploadedFile = $request->file('file');
        $filePath = $uploadedFile->store('uploads', 'public');

        $file = new File();
        $file->user_id = Auth::id();
        $file->file = $filePath;
        $file->link = $request->link;
        $file->save();

        return redirect()->route('files.index')->with('success', 'File uploaded successfully.');
    }

    return redirect()->back()->with('error', 'Please upload a valid file.');
}

}
