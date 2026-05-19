<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Contracts\View\View;

class ReceiptController extends Controller
{
    public function show(Payment $payment): View
    {
        abort_unless(
            auth()->check() && $payment->user_id === auth()->id(),
            403
        );

        $payment->load('user', 'campaign');

        return view('advertiser.receipt', ['payment' => $payment]);
    }
}
