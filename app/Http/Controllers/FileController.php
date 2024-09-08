<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\BlockchainService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    protected $blockchain;

    public function __construct(BlockchainService $blockchain)
    {
        $this->blockchain = $blockchain;
    }
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
            $fileHash = hash_file('sha256', storage_path('app/public/' . $filePath));

            $file = new File();
            $file->user_id = Auth::id();
            $file->file = $filePath;
            $file->link = $request->link;
            $file->save();

            try{
                $this->blockchain->addFile($fileHash, $request->link);
            }catch(Exception $e)
            {
                Log::error($e->getMessage());
            }

        return redirect()->route('files.index')->with('success', 'File uploaded successfully.');
    }

    return redirect()->back()->with('error', 'Please upload a valid file.');
}

}
