<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\StockProductCategory;
use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.stock.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.stock.supplier.create');
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
            'address' => 'required|string',
            'phone' => 'required',
        ]);

        Supplier::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        session()->flash('success', 'Supplier Created!');
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
        $supplier = Supplier::findOrFail($id);
        return view('dashboard.stock.supplier.edit', ['supplier'=>$supplier]);
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
            'address' => 'required|string',
            'phone' => 'required',
        ]);

        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        session()->flash('success', 'Supplier Updated!');
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
        $supplier_product_count = SupplierProduct::where('supplier_id', $id)->count();

        if($supplier_product_count == 0){
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            session()->flash('success', 'Supplier Removed!');
            return redirect()->back();
        }else{
            session()->flash('warning', 'Unable to remove Supplier, Already assigned to Product!');
            return redirect()->back();
        }
    }

    public function getAllSuppliers()
    {
        $suppliers = Supplier::all();

        return DataTables::of($suppliers)->make();
    }

    public function getSupplierById($id)
    {
        $supplier = Supplier::findOrFail($id);

        return response()->json([
            'error' => false,
            'data' => $supplier,
        ]);
    }

    public function getSupplierProductCategoryById($id)
    {
        $productCategory = SupplierProduct::with('stockProductCategory')->where('supplier_id', $id)->select('stock_product_category_id')->groupBy('stock_product_category_id')->get();

        return response()->json([
            'error' => false,
            'data' => $productCategory,
        ]);
    }

    public function getSupplierProductById($id, $id2)
    {
        $product = SupplierProduct::where('stock_product_category_id', $id)->where('supplier_id',$id2)->get();

        return response()->json([
            'error' => false,
            'data' => $product,
        ]);
    }

    public function getSupplierProductByCategoryId($id)
    {
        $product = SupplierProduct::where('stock_product_category_id', $id)->get();

        return response()->json([
            'error' => false,
            'data' => $product,
        ]);
    }
}
