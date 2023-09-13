<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bank;
use App\Payment;
use DataTables;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.payments.bank.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.payments.bank.create');
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

        Bank::create([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Bank Created!');
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
        $bank = Bank::findOrFail($id);
        return view('dashboard.payments.bank.edit', ['bank'=>$bank]);
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

        $bank = Bank::findOrFail($id);
        
        $bank->update([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Bank Updated!');
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
        $bank = Bank::findOrFail($id);

        // Check payment Category has assigned to other payment
        $paymentCount = Payment::where('bank', $id)->count();
        
        if($paymentCount != 0){
            session()->flash('warning', 'Unable to remove Bank, Already assigned to Payment!');
            return redirect()->back();
        }

        $bank->delete();

        session()->flash('success', 'Bank Removed!');
        return redirect()->back();
    }

    public function getAllBanks()
    {
        $banks = Bank::all();
        
        return DataTables::of($banks)->make();
    }
}
