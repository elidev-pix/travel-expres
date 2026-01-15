<?php 
namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Appwrite\Client;
use Appwrite\Services\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    protected $storage;

    public function __construct(Client $client)
    {
        // On utilise le singleton configuré dans le Provider
        $this->storage = new Storage($client);
    }

    public function index()
    {
        return view('profile.partials.document.student-document', [
            'user' => Auth::user(),
            'documents' => Document::where('user_id', Auth::id())->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        // Validation des données reçues du front (JS)
        $validated = $request->validate([
            'file_id'       => 'required|string',
            'original_name' => 'required|string',
            'mime_type'     => 'nullable|string',
            'size'          => 'nullable|integer',
        ]);

        $document = Document::create([
            'user_id'       => Auth::id(),
            'type'          => 'passport', // ou dynamique selon ton besoin
            'file_path'     => $validated['file_id'], 
            'original_name' => $validated['original_name'],
            'mime_type'     => $validated['mime_type'],
            'size'          => $validated['size'],
            'status'        => 'pending',
            'uploaded_at'   => now(),
        ]);

        return response()->json($document, 201);
    }

    public function destroy(Document $document)
    {
        // Suppression sur Appwrite via le SDK PHP (Composer)
        try {
            $this->storage->deleteFile(config('appwrite.bucket_id'), $document->file_path);
        } catch (\Exception $e) {
            // Si le fichier n'existe déjà plus sur Appwrite, on continue
        }

        // Suppression dans MySQL
        $document->delete();

        return response()->json(['message' => 'Supprimé avec succès']);
    }
}