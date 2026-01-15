<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Appwrite\Client;
use Appwrite\Services\Storage;
use Appwrite\InputFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    protected $storage;
    protected $bucketId;

    public function __construct()
    {
        $client = new Client();
        $client
            ->setEndpoint(env('APPWRITE_ENDPOINT'))
            ->setProject(env('APPWRITE_PROJECT_ID'))
            ->setKey(env('APPWRITE_API_KEY'));

        $this->storage = new Storage($client);
        $this->bucketId = env('APPWRITE_BUCKET_ID');
    }

    public function index()
    {
        $user = Auth::user();
        
        // On récupère les fichiers depuis Appwrite
        $filesList = [];
        try {
            $res = $this->storage->listFiles($this->bucketId);
            $filesList = $res['files'] ?? [];
        } catch (\Throwable $e) {
            // Optionnel : logger l'erreur pour le debug
            // \Log::error("Appwrite error: " . $e->getMessage());
        }

        // On retourne la vue avec TOUTES les variables nécessaires (user ET files)
        return view('profile.partials.document.student-document', [
            'user' => $user,
            'files' => $filesList,
        ]);
    }


public function store(Request $request)
{
    $request->validate([
        'file' => 'required|file|max:10240',
    ]);

    try {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->getRealPath();

        // Copier le fichier avec le bon nom pour que Appwrite le détecte
        $tempDir = sys_get_temp_dir();
        $newPath = $tempDir . DIRECTORY_SEPARATOR . $fileName;
        copy($filePath, $newPath);

        // Upload vers Appwrite
        $uploadedFile = $this->storage->createFile(
            $this->bucketId,
            'unique()',
            new InputFile($newPath)
        );

        // Nettoyer le fichier temporaire
        @unlink($newPath);

        Log::info('File uploaded successfully', ['fileId' => $uploadedFile['$id'] ?? 'unknown']);

        // Rediriger avec succès au lieu de retourner JSON
        return redirect()->route('document.student-document')->with('success', 'Fichier téléversé avec succès.');

    } catch (\Throwable $e) {
        Log::error('Upload failed: ' . $e->getMessage());
        return redirect()->route('document.student-document')->with('error', 'Upload failed: ' . $e->getMessage());
    }
}

    

public function show($fileId)
{
    $client = app(Client::class);
    $storage = new Storage($client);

    return $storage->getFileView(
        config('appwrite.bucket_id'),
        $fileId
    );
}


public function download($fileId)
{
    $client = app(Client::class);
    $storage = new Storage($client);

    return $storage->getFileDownload(
        config('appwrite.bucket_id'),
        $fileId
    );
}


public function update(Request $request, $fileId)
{
    $request->validate([
        'file' => 'required|file|max:10240',
    ]);

    $client = app(Client::class);
    $storage = new Storage($client);

    // 1️⃣ Supprimer l’ancien fichier
    $storage->deleteFile(
        config('appwrite.bucket_id'),
        $fileId
    );

    // 2️⃣ Upload du nouveau
    $file = $request->file('file');

    $newFile = $this->storage->createFile(
        $this->bucketId,
        'unique()',
        InputFile::fromPathname(
            $file->getPathname(),
            $file->getClientOriginalName()
        )
    );

    return response()->json($newFile);
}

}