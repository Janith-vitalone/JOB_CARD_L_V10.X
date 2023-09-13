<?php

namespace App\Http\Controllers;
use App\Stock;
use App\StockIn;
use App\StockInProduct;
use App\Supplier;
use App\SupplierProduct;
use App\StockProduct;
use App\StockProductCategory;
use DataTables;

use Illuminate\Http\Request;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.stock.stock_in.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view('dashboard.stock.stock_in.create',compact(
            'suppliers' ,
        ));
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
        $stock_in = StockIn::with('supplier')->where('id', $id)->get();
        $stock_in_products = StockInProduct::with('stockProductCategory','supplierProduct')->where('stock_in_id', $id)->get();
        //dd($stock_in_products);
        return view('dashboard.stock.stock_in.show',[
            'stock_in' => $stock_in,
            'stock_in_products' => $stock_in_products,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $stockin = StockIn::findOrFail($id);
        $stockinProducts = StockInProduct::where('stock_in_id', $id)->get();

        foreach($stockinProducts as $product){
            $remove_qty = $product->qty;
            $stock = Stock::where('supplier_product_id', $product->supplier_product_id)->get();
            $stock_qty = $stock[0]->qty;
            $stock_up = Stock::findOrFail($stock[0]->id);
            $new_stock_qty = $stock_qty - $remove_qty;

            if($stock_qty < $remove_qty){
                $new_stock_qty = 0;
                //update stock
                $stock_up->update([
                    'qty' => $new_stock_qty,
                ]);
            }else{
                $stock_up->update([
                    'qty' => $new_stock_qty,
                ]);
            }

            $stockinProduct = StockInProduct::findOrFail($product->id);
            $stockinProduct->delete();
        }
        $stockin->delete();
        
        session()->flash('success', 'StockIn Removed!');
        return redirect()->back();
    }

    public function createStockIn(Request $request)
    {
        $request->validate([
            'supplier' => 'required',
            'total' => 'required',
            'invoice' => 'required',
            'TableData' => 'required',
        ]);
        
        $stock_in = StockIn::create([
            'supplier_id' => $request->supplier,
            'invoice_no' => $request->invoice,
            'total' => $request->total,
        ]);

        $decodeJsonArray = json_decode($request->TableData, true);

        foreach($decodeJsonArray as $table_data){

            $category_id = StockProductCategory::where('name', $table_data['product_category'])->select('id')->get();
            $product_id = $table_data['product_id'];
            $product_category = $category_id[0]->id;
            $qty = $table_data['product_qty'];
            $stock_count = Stock::where("supplier_product_id", $product_id)->get();

            $stock_in_product = StockInProduct::create([
                'stock_in_id' => $stock_in->id,
                'stock_product_category_id' => $category_id[0]->id,
                'supplier_product_id' => $table_data['product_id'],
                'qty' => $table_data['product_qty'],
                'unit_price' => $table_data['product_price'],
            ]);

            if($stock_count->count() == 0)
            {
                Stock::create([
                    'stock_product_category_id' => $category_id[0]->id,
                    'supplier_product_id' => $product_id,
                    'qty' => $qty,
                ]);
            } else {
                $product_old_qty = $stock_count[0]->qty;
                $new_qty = $qty + $product_old_qty;
                
                $stock = Stock::findOrFail($stock_count[0]->id);
        
                $stock->update([
                    'qty' => $new_qty,
                ]);
            }
        }
        return response()->json([
            'error' => false,
        ]);
    }
    public function getAllStockIns()
    {
        $stockin = StockIn::with('supplier')->get();
        
        return DataTables::of($stockin)->make();
    }
}
