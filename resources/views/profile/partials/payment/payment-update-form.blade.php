<form action="{{ route('student.payment.update', $payment->id ?? 0) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Modifier le montant</label>
    <input type="number" name="amount" id="amount" value="{{ $payment->amount ?? '' }}" required> <br><br>
    <button type="submit">Enregistrer</button>
</form>