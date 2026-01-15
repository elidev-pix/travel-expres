@extends('base')

@section('title')

<a href="{{ route('document.student-document') }}">Dossiers</a>

@endsection

@section('left')

<div class="profile">
    <img src="{{ asset('images/pp.jpg')}}" alt="profile picture">
    <h5>Username</h5>
    <span>{{ $user->name ?? '' }}</span>
    <h5>Student ID</h5>
    <span>{{ $user->id ?? '' }}</span>
</div>

@endsection

@section('student_infos')
<div class="container">
    <input type="file" id="fileInput"> {{-- Changé l'ID pour éviter les conflits --}}
    <button id="uploadBtn">Upload</button>

    <ul id="document-list">
        @foreach($documents as $doc)
            <li>
                {{ $doc->original_name }} ({{ $doc->status }})
                {{-- URL de visualisation --}}
                <a href="{{ config('appwrite.endpoint') }}/storage/buckets/{{ config('appwrite.bucket_id') }}/files/{{ $doc->file_path }}/view?project={{ config('appwrite.project_id') }}" target="_blank">Voir</a>

                <button class="delete-btn" data-id="{{ $doc->id }}">Supprimer</button>
            </li>
        @endforeach
    </ul>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/appwrite@latest/dist/appwrite.min.js"></script>
<script>
    // Initialisation via les configs Laravel (injectées par le Provider au final)
    const client = new Appwrite.Client()
        .setEndpoint('{{ config("appwrite.endpoint") }}')
        .setProject('{{ config("appwrite.project_id") }}');

    const storage = new Appwrite.Storage(client);
    const bucketId = '{{ config("appwrite.bucket_id") }}';

    document.addEventListener('DOMContentLoaded', function() {
        const uploadBtn = document.getElementById('uploadBtn');
        const fileInput = document.getElementById('fileInput');
        console.log('Document ready');
        console.log(uploadBtn);

        // Gestion de l'Upload
        if (uploadBtn) {
            uploadBtn.addEventListener('click', async () => {
                console.log('Upload button clicked');
                const file = fileInput.files[0];
                if (!file) return alert("Sélectionnez un fichier");

                uploadBtn.disabled = true;
                uploadBtn.textContent = "Chargement...";

                try {
                    // 1. Upload vers Appwrite
                    const response = await storage.createFile(bucketId, Appwrite.ID.unique(), file);

                    // 2. Envoi des métadonnées vers ton DocumentController (MySQL)
                    const serverResponse = await fetch('{{ route("documents.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            type: 'passport', 
                            file_id: response.$id, // L'ID généré par Appwrite
                            original_name: response.name,
                            mime_type: response.mimeType,
                            size: response.sizeOriginal
                        })
                    });

                    if (serverResponse.ok) {
                        window.location.reload();
                    } else {
                        throw new Error("Erreur lors de l'enregistrement en base de données.");
                    }
                } catch (error) {
                    alert(error.message);
                    uploadBtn.disabled = false;
                    uploadBtn.textContent = "Upload";
                }
            });
        }

        // Gestion de la Suppression (Délégation d'événement)
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const docId = this.getAttribute('data-id');
                if (!confirm('Supprimer ce document ?')) return;

                const res = await fetch(`/documents/${docId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                if (res.ok) window.location.reload();
            });
        });
    });
</script>
@endsection