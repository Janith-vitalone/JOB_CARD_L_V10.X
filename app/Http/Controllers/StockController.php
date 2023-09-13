<?php

namespace App\Http\Controllers;
use App\Stock;
use App\Substock;
use App\UserHasRole;
use App\StockApprovel;
use DataTables;

use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.stock.stock.index');
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
        $stock = Stock::with('stockProductCategory','product',)->findOrFail($id);
        return view('dashboard.stock.stock.edit',['stock'=>$stock]);
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
            'qty' => 'required',
        ]);
        $currentUser = auth()->user();
        $user = $currentUser->id;
        
        //check the user role
        $role = UserHasRole::where('user_id',$user)->select('user_role_id')->get();
        $userRole = $role[0]->user_role_id;
        // $userRole = 2;

        if($userRole == 1)
        {
            $stock = Stock::findOrFail($id);
            $stock->update([
                'qty' => $request->qty,
            ]);

            session()->flash('success', 'Stock Updated!');
            return redirect()->back();
        }
        else{
            $status = 0;
            StockApprovel::create([
                'stock_id' => $id,
                'user_id' => $user,
                'qty' => $request->qty,
                'status' => $status,
            ]);

            session()->flash('success', 'Stock Update Request Under Review!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $substock_count = Substock::where('stock_id', $id)->count();

        if($substock_count != 0){
            $substocks = Substock::where('stock_id', $id)->get();

            foreach($substocks as $substock){
                $substock->delete();
            }
        }
        
        $stock->delete();

        session()->flash('success', 'Stock Removed!');
        return redirect()->back();
    }

    public function getAllStocks()
    {
        $stock = Stock::with('stockProductCategory','product',)->get();
        
        return DataTables::of($stock)->make();
    }
}
