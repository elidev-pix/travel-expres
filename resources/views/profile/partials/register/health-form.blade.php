<form id="profileForm" action="{{ route('save.form', ['type' => $type ?? 'health']) }}" method="POST">
    @csrf
    @method('POST')
    <div class="mb-3">
        <label>Taille</label>
        <input type="text" name="height" class="form-control" placeholder="Taille" required>
    </div>
    <div class="mb-3">
        <label>Poids</label>
        <input type="text" name="weight" class="form-control" placeholder="Poids" required>
    </div>
    <div class="mb-3">
        <label>Antécédants médicaux</label>
        <input type="text" name="medical_history" class="form-control" placeholder="Antécédants médicaux" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>