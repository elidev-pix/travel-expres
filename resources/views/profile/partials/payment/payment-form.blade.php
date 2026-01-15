<form id="profileForm" action="{{ route('student.save.form', ['type' => $type ?? 'payment']) }}" method="POST">
    @csrf
    @method('POST')
     <div class="mb-3">
        <label>Date</label>
        <input type="date" name="paid_at" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Montant</label>
        <input type="number" name="amount" class="form-control" placeholder="Montant" step="0.01" required>
    </div>
    <input type="hidden" name="currency" value="XOF">
    <div class="mb-3">
        <label>Methode de paiement</label>
        <select name="method" class="form-control">
            <option value="Mobile Money">Mobile Money</option>
            <option value="Cash">Cash</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Credit Card">Credit Card</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Référence</label>
        <input type="text" name="reference" class="form-control" placeholder="Référence" required>
    </div>
    <div class="mb-3">
        <label>Activité</label>
        <input type="text" name="activity" class="form-control" placeholder="Activité" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>