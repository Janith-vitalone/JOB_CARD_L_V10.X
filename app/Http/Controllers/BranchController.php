<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Payment;
use DataTables;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.payments.branch.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.payments.branch.create');
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

        Branch::create([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Branch Created!');
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
        $branch = Branch::findOrFail($id);
        return view('dashboard.payments.branch.edit', ['branch'=>$branch]);
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

        $branch = Branch::findOrFail($id);

        $branch->update([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Branch Updated!');
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
        $branch = Branch::findOrFail($id);

        // Check payment Category has assigned to other payment
        $paymentCount = Payment::where('branch', $id)->count();

        if($paymentCount != 0){
            session()->flash('warning', 'Unable to remove Branch, Already assigned to Payment!');
            return redirect()->back();
        }

        $branch->delete();

        session()->flash('success', 'Branch Removed!');
        return redirect()->back();
    }

    public function getAllBranchs()
    {
        $branchs = Branch::all();

        return DataTables::of($branchs)->make();
    }
}
