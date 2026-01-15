<form id="profileForm" action="{{ route('save.form', ['type' => $type ?? 'program']) }}" method="POST">
    @csrf
    @method('POST')
    <div class="mb-3">
        <label>Filière</label>
        <input type="text" name="program"  required>
    </div>
    <div class="mb-3">
        <label>Université</label>
        <input type="text" name="university" class="form-control" placeholder="Université" required>
    </div>
    <div class="mb-3">
        <label>Niveau</label>
        <select name="level" class="form-control">
            <option value="Année de langue">Année de langue</option>
            <option value="licence">Licence</option>
            <option value="Master">Master</option>
            <option value="Doctorat">Doctorat</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Année en cours</label>
        <input type="text" name="academic_year" class="form-control" placeholder="Année en cours" required>
    </div>
    <div class="mb-3">
        <label>Ville</label>
        <input type="text" name="city" class="form-control" placeholder="Ville">
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>