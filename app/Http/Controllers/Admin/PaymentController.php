<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Payment;

use Session;

class PaymentController extends Controller
{
    public function index() {
        $this -> authorize("view", Payment::class);

        $payment_methods = Payment::all();

        return view("admin.payment.index", compact("payment_methods"));
    }

    public function edit(Payment $payment) {
        $this -> authorize("update", Payment::class);

        return view("admin.payment.edit", compact("payment"));
    }

    public function update(Request $request, Payment $payment) {
        $this -> authorize("update", Payment::class);

        $payment -> status = $request -> filled("status");
        $payment -> save();

        Session::flash("success", "Payment status was updated successfully!");

        return redirect() -> route("admin.payment.index");
    }
}
