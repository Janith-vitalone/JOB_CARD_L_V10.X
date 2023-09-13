<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentCategory;
use App\OtherPayment;
use DataTables;

class PaymentCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.payments.payment_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.payments.payment_categories.create');
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
            'name' => 'required|string',
        ]);

        PaymentCategory::create([
            'category' => $request->name,
        ]);

        session()->flash('success', 'Payment Category Created!');
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
        $paymentCategory = PaymentCategory::findOrFail($id);
        return view('dashboard.payments.payment_categories.edit', ['paymentCategory'=>$paymentCategory]);
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
            'name' => 'required|string',
        ]);

        $paymentCategory = PaymentCategory::findOrFail($id);
        
        $paymentCategory->update([
            'category' => $request->name,
        ]);

        session()->flash('success', 'Payment Category Updated!');
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
        $paymentCategory = PaymentCategory::findOrFail($id);

        // Check payment Category has assigned to other payment
        $paymentCount = OtherPayment::where('paymentCategories_id', $id)->count();
        
        if($paymentCount != 0){
            session()->flash('warning', 'Unable to remove Payment Category, Already assigned to other payment!');
            return redirect()->back();
        }

        $paymentCategory->delete();

        session()->flash('success', 'Payment Category Removed!');
        return redirect()->back();
    }

    public function getAllCategories()
    {
        $paymentCategories = PaymentCategory::all();
        
        return DataTables::of($paymentCategories)->make();
    }
}
