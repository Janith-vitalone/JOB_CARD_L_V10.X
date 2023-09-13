<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockProductCategory;
use App\StockProduct;
use App\SupplierProduct;
use App\Supplier;
use App\Unit;
use App\Stock;
use App\StockIn;
use App\StockInProduct;
use DataTables;

class StockProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.stock.stock_product_category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.stock.stock_product_category.create');
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

        StockProductCategory::create([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Stock Product Category Created!');
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
        $stockProductCategory = StockProductCategory::findOrFail($id);
        return view('dashboard.stock.stock_product_category.edit', ['stockProductCategory'=>$stockProductCategory]);
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

        $stockProductCategory = StockProductCategory::findOrFail($id);
        
        $stockProductCategory->update([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Stock Product Category Updated!');
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
        $stockProductCategory = StockProductCategory::findOrFail($id);
        
        // Check payment Category has assigned to other payment
        $productCount = SupplierProduct::where('stock_product_category_id', $id)->count();
        
        if($productCount != 0){
            session()->flash('warning', 'Unable to remove Product Category, Already assigned to product!');
            return redirect()->back();
        }

        $stockProductCategory->delete();

        session()->flash('success', 'Payment Category Removed!');
        return redirect()->back();
    }

    public function getAllCategories()
    {
        $stockProductCategories = StockProductCategory::all();
        
        return DataTables::of($stockProductCategories)->make();
    }
}
