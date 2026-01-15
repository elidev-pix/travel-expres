@extends('base')

@section('title')

<a href="{{ route('payment.student-payment') }}">Historique de paiements</a>

@endsection

@section('student_infos')
<div class="container">
    <div class="upload-box">
        <input type="file" id="appwrite-file">
        <button id="btn-upload" class="btn btn-primary">Uploader le document</button>
    </div>

    <ul class="mt-4">
        @foreach($documents as $doc)
            <li>
                {{ $doc->original_name }} - <strong>{{ $doc->status }}</strong>
                <a href="{{ config('appwrite.endpoint') }}/storage/buckets/{{ config('appwrite.bucket_id') }}/files/{{ $doc->file_path }}/view?project={{ config('appwrite.project_id') }}" target="_blank">Voir</a>
                <button onclick="confirmDelete({{ $doc->id }})" class="text-red-500">Supprimer</button>
            </li>
        @endforeach
    </ul>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/appwrite@latest/dist/appwrite.min.js"></script>
<script>
    // Configuration JS
    const sdk = new Appwrite.Client()
        .setEndpoint('{{ config("appwrite.endpoint") }}')
        .setProject('{{ config("appwrite.project_id") }}');

    const storage = new Appwrite.Storage(sdk);
    const bucketId = '{{ config("appwrite.bucket_id") }}';

    document.getElementById('btn-upload')?.addEventListener('click', async () => {
        const fileInput = document.getElementById('appwrite-file');
        const file = fileInput.files[0];
        const btn = document.getElementById('btn-upload');

        if (!file) {
            console.warn("Tentative d'upload sans fichier sélectionné.");
            return alert("Choisis un fichier");
        }

        console.log("Début de la procédure d'upload...");
        console.log("Fichier sélectionné:", { name: file.name, size: file.size, type: file.type });

        btn.disabled = true;
        btn.textContent = "Upload vers Appwrite...";

        try {
            // 1. Envoi à Appwrite
            console.log("Envoi vers le bucket Appwrite: " + bucketId);
            const uploadedFile = await storage.createFile(
                bucketId, 
                Appwrite.ID.unique(), 
                file
            );
            console.log("Succès Appwrite ! Réponse reçue:", uploadedFile);

            // 2. Envoi des infos à Laravel
            btn.textContent = "Enregistrement sur Laravel...";
            console.log("Envoi des métadonnées vers Laravel...");

            const response = await fetch('{{ route("documents.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // Important pour recevoir du JSON en cas d'erreur
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    file_id: uploadedFile.$id,
                    original_name: uploadedFile.name,
                    mime_type: uploadedFile.mimeType,
                    size: uploadedFile.sizeOriginal,
                    type: 'passport'
                })
            });

            const responseData = await response.json();

            if (response.ok) {
                console.log("Succès Laravel ! Document créé en BDD:", responseData);
                window.location.reload();
            } else {
                // Erreurs de validation Laravel (422) ou erreurs serveur (500)
                console.error("Erreur Laravel détectée !");
                console.table(responseData.errors); // Affiche les erreurs de validation proprement sous forme de tableau
                throw new Error(responseData.message || "Erreur lors de l'enregistrement MySQL.");
            }

        } catch (error) {
            // Capturer les erreurs réseau, Appwrite (403, 404) ou Laravel
            console.error("--- ERREUR CRITIQUE ---");
            console.error("Type d'erreur:", error.constructor.name);
            console.error("Message:", error.message);
            
            if (error.response) {
                console.error("Détails de la réponse Appwrite/Serveur:", error.response);
            }
            
            alert("Une erreur est survenue. Vérifie la console (F12) pour plus de détails.");
        } finally {
            btn.disabled = false;
            btn.textContent = "Uploader le document";
        }
    });

    async function confirmDelete(id) {
        if (!confirm("Supprimer ce document ?")) return;
        
        console.log("Tentative de suppression du document ID: " + id);
        
        try {
            const res = await fetch(`/documents/${id}`, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            if (res.ok) {
                console.log("Suppression réussie.");
                window.location.reload();
            } else {
                const errorData = await res.json();
                console.error("Erreur lors de la suppression:", errorData);
            }
        } catch (error) {
            console.error("Erreur réseau lors de la suppression:", error);
        }
    }
</script>
@endsection