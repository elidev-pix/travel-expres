<form id="profileForm" action="{{ route('save.form', ['type' => $type ?? 'identification']) }}" method="POST">
    @csrf
    @method('POST')
    <div class="mb-3">
        <label>Numéro de Passeport</label>
        <input type="text" name="passport_number" class="form-control" placeholder="Numéro de Passeport" required>
    </div>
    <div class="mb-3">
        <label>CNIB</label>
        <input type="text" name="cnib_number" class="form-control" placeholder="Numéro de CNIB" required>
    </div>
    <div class="mb-3">
        <label>Nationalité</label>
        <input type="text" name="nationality" class="form-control" placeholder="Nationalité" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>