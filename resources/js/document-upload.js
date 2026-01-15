import { storage, bucketId, id } from './appwrite.js';

document.addEventListener('DOMContentLoaded', () => {
    const uploadBtn = document.getElementById('uploadBtn');
    const fileInput = document.getElementById('file');

    if (!uploadBtn) {
        console.error('uploadBtn not found');
        return;
    }

    uploadBtn.addEventListener('click', async () => {
        const file = fileInput.files[0];
        if (!file) {
            alert("Choisis un fichier");
            return;
        }

        uploadBtn.disabled = true;
        uploadBtn.textContent = 'Upload en cours...';

        try {
            console.log('Uploading to Appwrite...', { bucketId, file: file.name });
            
            const response = await storage.createFile(
                bucketId,
                id.unique(),
                file
            );

            console.log('Upload réussi:', response);

            // Envoyer les métadonnées à Laravel
            const fetchResponse = await fetch('/documents', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    type: 'passport',
                    file_id: response.$id,
                    original_name: response.name,
                    mime_type: response.mimeType,
                    size: response.sizeOriginal
                })
            });

            if (fetchResponse.ok) {
                alert("Fichier uploadé et enregistré !");
                window.location.reload();
            } else {
                const errorData = await fetchResponse.json();
                alert("Erreur lors de l'enregistrement: " + JSON.stringify(errorData));
            }
        } catch (e) {
            console.error('Upload error:', e);
            alert("Erreur upload: " + e.message);
        } finally {
            uploadBtn.disabled = false;
            uploadBtn.textContent = 'Upload';
        }
    });
});
