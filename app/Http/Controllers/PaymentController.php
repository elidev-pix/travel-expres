<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // récupérer tous les paiements de l'utilisateur
        $table_payments = $user->payments()->orderBy('paid_at', 'desc')->get();

        return view('profile.partials.payment.student-payment', [
            'user' => $user,
            'student_payments' => $table_payments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profile.partials.payment.student-payment');
    }


     public function getForm($type)
    {
        $forms = [
            'payment' => 'profile.partials.payment.payment-form',
           
        ];

        if (!array_key_exists($type, $forms)) {
            return response()->json(['error' => 'Formulaire non trouvé'], 404);
        }

        return view($forms[$type], ['type' => $type]);
    }

    
    public function storeForm(Request $request, $type)
    {
        switch ($type) {
            case 'payment':
                $rules = [
                    'amount' => ['required', 'numeric', 'min:0'],
                    'currency' => ['required', 'string', 'max:3'],
                    'method' => ['nullable', 'in:Mobile Money,Cash,Bank Transfer,Credit Card'],
                    'reference' => ['nullable', 'string', 'max:255'],
                    'status' => ['nullable', 'in:soldé,En attente de règlement,Règlement partiel'],
                    'activity' => ['required', 'string', 'max:255'],
                    'paid_at' => ['nullable', 'date'],
                ];
                break;
          
            default:
                return redirect()->back()->with('error', 'Type de formulaire invalide.');
        }

        $validated = $request->validate($rules);

        // set paid_at to now() if not provided, then create a new payment record for this user
        $paymentData = $validated + ['user_id' => Auth::id()];
        if (empty($paymentData['paid_at'])) {
            $paymentData['paid_at'] = now();
        }
        $payment = Payment::create($paymentData);

        return redirect()->route('payment.student-payment')->with('success', 'Paiement enregistré avec succès.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        // return the update form partial populated with the payment
        return view('profile.partials.payment.payment-update-form', ['type' => 'payment-update', 'payment' => $payment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $id)
    {
        $id->update([
            'amount' => $request->amount
        ]);

        return redirect()->route('payment.student-payment');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $id)
    {
        $id->delete();
        return redirect()->route('payment.student-payment');
    }
}
