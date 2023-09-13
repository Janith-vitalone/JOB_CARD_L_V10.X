<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockProductCategory;
use App\StockProduct;
use DataTables;

class StockProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.stock.stock_product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = StockProductCategory::all();
        return view('dashboard.stock.stock_product.create', compact('categories'));
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
            'name' => 'required | string',
            'price' => 'required',
            'qty' => 'required',
        ]);

        StockProduct::create([
            'stock_product_category_id' => $request->category,
            'name' => $request->name,
            'note' => $request->note,
            'price' => $request->price,
            'qty' => $request->qty,
            'reorder_level' => $request->reorder_level
        ]);

        session()->flash('success', 'Stock Product Created!');
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
        $stockProduct = StockProduct::findOrFail($id);
        $categories = StockProductCategory::all();
        return view('dashboard.stock.stock_product.edit', [
            'stockProduct' => $stockProduct,
            'categories' => $categories
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
            'name' => 'required | string',
            'price' => 'required',
            'qty' => 'required',
        ]);

        $stockProduct = StockProduct::findOrFail($id);
        
        $stockProduct->update([
            'stock_product_category_id' => $request->category,
            'name' => $request->name,
            'note' => $request->note,
            'price' => $request->price,
            'qty' => $request->qty,
            'reorder_level' => $request->reorder_level
        ]);


        session()->flash('success', 'Stock Product Updated!');
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
        $stockProduct = StockProduct::findOrFail($id);

        $stockProduct->delete();

        session()->flash('success', 'Payment Removed!');
        return redirect()->back();
    }

    public function getAllProducts()
    {
        $stockProducts = StockProduct::with('stockProductCategory')->get();
        
        return DataTables::of($stockProducts)->make();
    }
}
