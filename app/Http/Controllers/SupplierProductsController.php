<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockProductCategory;
use App\SupplierProduct;
use App\Supplier;
use App\Unit;
use App\Stock;
use App\StockIn;
use App\StockInProduct;
use DataTables;

class SupplierProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.stock.supplier_product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = StockProductCategory::all();
        $suppliers = Supplier::all();
        $units = Unit::all();
        return view('dashboard.stock.supplier_product.create', compact('categories','suppliers','units'));
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
            'supplier' => 'required',
            'category' => 'required',
            'name' => 'required | string',
            'unit' => 'required',
        ]);

        if(!empty($request->width))
        {
            $request->validate([
                'width' => 'required',
                'height' => 'required'
            ]);

            SupplierProduct::create([
                'supplier_id' => $request->supplier,
                'stock_product_category_id' => $request->category,
                'name' => $request->name,
                'unit_id' => $request->unit,
                'height' => $request->height,
                'width' => $request->width,
            ]);
    
            session()->flash('success', 'Supplier Product Created!');
            return redirect()->back();
        }
        
        SupplierProduct::create([
            'supplier_id' => $request->supplier,
            'stock_product_category_id' => $request->category,
            'name' => $request->name,
            'unit_id' => $request->unit,
        ]);

        session()->flash('success', 'Supplier Product Created!');
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
        $supplierProduct = SupplierProduct::with('stockProductCategory','supplier','unit')->findOrFail($id);
        $categories = StockProductCategory::all();
        $suppliers = Supplier::all();
        $units = Unit::all();
        return view('dashboard.stock.supplier_product.edit', [
            'supplierProduct' => $supplierProduct,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'units' => $units,
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
            'supplier' => 'required',
            'category' => 'required',
            'name' => 'required | string',
            'unit' => 'required',
        ]);

        $supplierProduct = SupplierProduct::findOrFail($id);
        
        if(!empty($request->width))
        {
            $request->validate([
                'width' => 'required',
                'height' => 'required'
            ]);

            $supplierProduct->update([
                'supplier_id' => $request->supplier,
                'stock_product_category_id' => $request->category,
                'name' => $request->name,
                'unit_id' => $request->unit,
                'height' => $request->height,
                'width' => $request->width,
            ]);
    
            session()->flash('success', 'Supplier Product Updated!');
            return redirect()->back();
        }
        
        $supplierProduct->update([
            'supplier_id' => $request->supplier,
            'stock_product_category_id' => $request->category,
            'name' => $request->name,
            'unit_id' => $request->unit,
        ]);

        session()->flash('success', 'Supplier Product Updated!');
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
        $supplierProduct = SupplierProduct::findOrFail($id);

        $stock_in_count = StockInProduct::where('supplier_product_id',$id)->count();

        $stock_count = Stock::where('supplier_product_id',$id)->count();

        if($stock_in_count == 0){
            if($stock_count == 0){
                $supplierProduct->delete();

                session()->flash('success', 'Product Removed!');
                return redirect()->back();
            }
            session()->flash('warning', 'Unable to remove Product, Already assigned to stock!');
            return redirect()->back();
        }
        else{
            session()->flash('warning', 'Unable to remove Product, Already assigned to stock!');
            return redirect()->back();
        }
    }

    public function getAllProducts()
    {
        $supplierProducts = SupplierProduct::with('stockProductCategory','supplier','unit')->get();
        
        return DataTables::of($supplierProducts)->make();
    }

    public function getProductById($id)
    {
        $availableQty = Stock::where('supplier_product_id', $id)->get();
        return DataTables::of($availableQty)->make();
    }
}
