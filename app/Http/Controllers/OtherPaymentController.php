<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherPayment;
use App\Models\PaymentCategory;
use DataTables;

class OtherPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.payments.other_payment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pay_categories = PaymentCategory::all();
        return view('dashboard.payments.other_payment.create', compact('pay_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'amount' => 'required'
        ]);

        if(!empty($request->bank)){
            $request->validate([
                'bank' => 'required',
                'cheque_no' => 'required |unique:other_payments',
                'banking_date' => 'required'
            ]);

            OtherPayment::create([
                'paymentCategories_id' => $request->category,
                'bank' => $request->bank,
                'description' => $request->description,
                'cheque_no' => $request->cheque_no,
                'banking_date' => $request->banking_date,
                'amount' => $request->amount,
            ]);
            session()->flash('success', 'Other Payment Created!');
            return redirect()->back();
        }
        OtherPayment::create([
            'paymentCategories_id' => $request->category,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        session()->flash('success', 'Other Payment Created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = OtherPayment::with('paymentCategory')->findOrFail($id);
        $pay_categories = PaymentCategory::all();

        return view('dashboard.payments.other_payment.edit', [
            'payment' => $payment,
            'pay_categories' => $pay_categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'amount' => 'required'
        ]);

        $otherPayment = OtherPayment::findOrFail($id);

        if(!empty($request->bank)){
            $request->validate([
                'bank' => 'required',
                'cheque_no' => 'required',
                'banking_date' => 'required'
            ]);

            $otherPayment->update([
                'paymentCategories_id' => $request->category,
                'bank' => $request->bank,
                'description' => $request->description,
                'cheque_no' => $request->cheque_no,
                'banking_date' => $request->banking_date,
                'amount' => $request->amount,
            ]);
            session()->flash('success', 'Other Payment Updated!');
            return redirect()->back();
        }
        if(!empty($request->cheque_no)){
            $request->validate([
                'bank' => 'required',
                'cheque_no' => 'required',
                'banking_date' => 'required'
            ]);

            $otherPayment->update([
                'paymentCategories_id' => $request->category,
                'bank' => $request->bank,
                'description' => $request->description,
                'cheque_no' => $request->cheque_no,
                'banking_date' => $request->banking_date,
                'amount' => $request->amount,
            ]);
            session()->flash('success', 'Other Payment Updated!');
            return redirect()->back();
        }
        if(!empty($request->banking_date)){
            $request->validate([
                'bank' => 'required',
                'cheque_no' => 'required',
                'banking_date' => 'required'
            ]);

            $otherPayment->update([
                'paymentCategories_id' => $request->category,
                'bank' => $request->bank,
                'description' => $request->description,
                'cheque_no' => $request->cheque_no,
                'banking_date' => $request->banking_date,
                'amount' => $request->amount,
            ]);
            session()->flash('success', 'Other Payment Updated!');
            return redirect()->back();
        }
        $otherPayment->update([
            'paymentCategories_id' => $request->category,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        session()->flash('success', 'Other Payment Updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $otherPayment = OtherPayment::findOrFail($id);
        $otherPayment->delete();

        session()->flash('success', 'Other Payment Removed!');
        return redirect()->back();
    }

    public function getAllPayments()
    {
        $payments = OtherPayment::with('paymentCategory')->get();

        return DataTables::of($payments)->make();
    }
}
