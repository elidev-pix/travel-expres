<form id="profileForm" action="{{ route('save.form', ['type' => $type ?? 'personal']) }}" method="POST">
    @csrf
    @method('POST')
    <div class="mb-3">
        <label>Genre</label>
        <select name="gender" class="form-control">
            <option value="male">male</option>
            <option value="female">female</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Date de naissance</label>
        <input type="date" name="dob" class="form-control" placeholder="Date de naissance" required>
    </div>
    <div class="mb-3">
        <label>Adresse</label>
        <input type="text" name="address" class="form-control" placeholder="Adresse" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>