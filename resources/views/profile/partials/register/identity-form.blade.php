<form id="profileForm" action="{{ route('save.form', ['type' => $type ?? 'identity']) }}" method="POST">
    @csrf
    @method('POST')
    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="last_name" class="form-control" placeholder="Nom" required>
    </div>
    <div class="mb-3">
        <label>Prénom (s)</label>
        <input type="text" name="first_name" class="form-control" placeholder="Prénom"  required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>