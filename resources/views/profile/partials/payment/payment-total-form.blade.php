<form id="profileForm" action="{{ route('save.form', ['type' => $type ?? 'payment-total']) }}" method="POST">
    @csrf
    @method('POST')
    <div class="mb-3">
        <label>Reste à régler</label>
        <input type="text" name="remains" class="form-control" placeholder="Reste à régler" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>