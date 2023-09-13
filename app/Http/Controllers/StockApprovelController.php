<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockApprovel;
use App\Stock;
use DataTables;

class StockApprovelController extends Controller
{
    public function __construct()
    {
        $controller = explode('@', request()->route()->getAction()['controller'])[0];

        $this->middleware('allowed:' . $controller)->only(['index', 'create', 'store', 'update', 'destroy', 'edit', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.stock.stock.approval');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $approval = StockApprovel::findOrFail($id);
        $stock = Stock::findOrFail($approval->stock_id);
        $status = 1;

        $stock->update([
            'qty' => $approval->qty,
        ]);
        
        $approval->update([
            'status'=> $status,
        ]);

        session()->flash('success', 'Stock Update Request Approved!');
        return redirect()->back();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAllApprovals()
    {
        $approvals = StockApprovel::with('stock','user',)->where('status', 0)->get();
        $tableData = [];
        foreach($approvals as $approval)
        {
            $stock = Stock::with('stockProductCategory','product')->where('id',$approval->stock_id)->get();
            $tableData[] = [
                'id'=>$approval->id,
                'stock'=>$stock,
                'user'=>$approval->user,
                'qty'=>$approval->qty,
                'status'=>$approval->status,
            ];
        }
        return DataTables::of($tableData)->make();
    }
}
