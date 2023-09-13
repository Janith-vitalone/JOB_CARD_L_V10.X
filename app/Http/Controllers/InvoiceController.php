<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Job;
use App\Models\Payment;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\StockProductCategory;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\InvoiceHasProduct;
use App\Models\Client;

class InvoiceController extends Controller
{

//    public function __construct()
//    {
//        $controller = explode('@', request()->route()->getAction()['controller'])[0];
//
//        $this->middleware('allowed:' . $controller);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('dashboard.job_management.invoice.index', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = StockProductCategory::all();
        $clients = Client::all();

        return view('dashboard.job_management.invoice.create', [
            'categories' => $categories,
            'clients' => $clients,
        ]);
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
    public function show(Request $request, $id)
    {
        // if (Auth::user()->id != 7 && Auth::user()->id != 10 && Auth::user()->id != 3)
        // {
        //     abort(401, 'Unauthorized Area');
        // }

        $payment = Payment::with('invoice', 'invoice.job', 'invoice.job.client', 'invoice.job.user', 'invoice.job.jobHasTasks', 'invoice.job.jobHasProducts')->findOrFail($id);
        //dd($payment);
        return view('dashboard.job_management.invoice.print', [
            'payment' => $payment,
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
        $invoice = Invoice::with('client', 'invoiceproducts', 'invoiceproducts.products', 'invoiceproducts.products.stockProductCategory', 'payments')->findOrFail($id);
        $categories = StockProductCategory::all();
        $invoice_products = InvoiceHasProduct::where('invoice_id',$invoice->id)->with('products')->get();
        if($invoice->Client != null){
            $client = Client::findOrFail($invoice->Client);
        }else{
            $client = [
                'name' => "none",
                'contact_person' => "none",
                'phone' => "none",
            ];
        }
        return view('dashboard.job_management.invoice.edit', compact('invoice', 'invoice_products', 'categories', 'client'));
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
            'invoice_id' => 'required',
            'total' => 'required',
            'TableData' => 'required',
        ]);
        $id = $request->invoice_id;
        $total = $request->total;
        $subtotal = $request->subtotal;
        $invoice = Invoice::with('payments')->findOrFail($id);
        $paid_amount = $invoice->payments->sum('paid_amount');
        $discount = 0;

        if(!empty($request->discount)){
            $discount = $subtotal - $total;
        }
        //check paid amount and the total
        if($paid_amount < $total){
            $paymentStatus = 'partially_paid';

            $invoice->update([
                'sub_total' => $subtotal,
                'discount' => $discount,
                'grand_total' => $total,
                'payment_status' => $paymentStatus,
            ]);
            // dd("have to pay");
        }else{

            $invoice->update([
                'sub_total' => $subtotal,
                'discount' => $discount,
                'grand_total' => $total,
            ]);
            // dd("balance");
        }

        //old product delete
        $oldProducts = InvoiceHasProduct::where('invoice_id', $id)->get();

        foreach($oldProducts as $oldProduct){
            //stock product
            $productStock = Stock::where('supplier_product_id', $oldProduct->product_id)->get();
            // get invoiced qty
            $invoicedQty = $oldProduct->qty;
            $productStock = Stock::findOrFail($productStock[0]->id);

            // invoiced qty add to current qty
            $finalQty = $productStock->qty + $invoicedQty;
            // update stock
            $productStock->update([
                'qty' => $finalQty,
            ]);
            //delete old invoiced product
            $oldProduct->delete();
        }

        // new product
        $decodeJsonArray = json_decode($request->TableData, true);

        foreach($decodeJsonArray as $table_data){
            // Updated product id
            $product_id = $table_data['product_id'];
            // Updated product Qty
            $qty = $table_data['product_qty'];
            //get current stock for the product
            $stock_count = Stock::where("supplier_product_id", $product_id)->get();

            InvoiceHasProduct::create([
                'invoice_id' => $invoice->id,
                'product_id' => $product_id,
                'qty' => $qty,
                'unit_price' => $table_data['product_price'],
                'description' => $table_data['product_description'],
            ]);
            // get current qty form stock
            $product_old_qty = $stock_count[0]->qty;
            // calculate new stock qty for the product
            $new_qty = $product_old_qty - $qty;
            // get stock to update
            $stock = Stock::findOrFail($stock_count[0]->id);
            //update stock
            $stock->update([
                'qty' => $new_qty,
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Invoice Updated'
        ]);
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

    public function createInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|exists:injobs,id',
            'discount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'payment_method' => 'required',
    	]);

    	if($validator->fails())
    	{
    		return response()->json(['error' => $validator->errors()], 200);
        }

        if($request->payment_method == 'cheque'){
            $cheque_no = $request->cheque_no;
            $bank = $request->bank;
            $branch = $request->branch;
            $cheque_date = $request->cheque_date;

            if($cheque_no == null){
                return response()->json([
                    'error' => [
                        'message' => ['Cheque No is Empty, Please Enter Cheque No']
                    ],
                    'message' => 'Cheque No is Empty'
                ]);
            }else if($bank == null){
                return response()->json([
                    'error' => [
                        'message' => ['Not Selected Bank, Please Select Bank']
                    ],
                    'message' => 'Not Selected Bank'
                ]);
            }else if($branch == null){
                return response()->json([
                    'error' => [
                        'message' => ['Not Selected Branch, Please Select Branch']
                    ],
                    'message' => 'Not Selected Branch'
                ]);
            }else if($cheque_date == null){
                return response()->json([
                    'error' => [
                        'message' => ['Cheque Date is Empty, Please Enter Cheque Date']
                    ],
                    'message' => 'Cheque Date is Empty'
                ]);
            }
        }else {
            $cheque_no = null;
            $bank = null;
            $branch = null;
            $cheque_date = null;
        }
        $job = Job::find($request->job_id);

        // Check if Job is already Invoiced or Not
        if($job->isInvoiced())
        {
            return response()->json([
                'error' => [
                    'message' => ['Already Invoiced, Please add Payment']
                ],
                'message' => 'Already Invoiced'
            ]);
        }

        $jobsTotal = $job->jobHasTasks->sum('total');
        $productTotal = $job->jobHasProducts->sum('total');

        $subTotal = $jobsTotal + $productTotal;
        $discount  = $request->discount;
        $paidAmount = $request->paid_amount;

        $grandTotal = $subTotal - ($subTotal * ($discount / 100));
        $invoiceNo = $this->generateNewInvoiceNo();
        $paymentStatus = 'unpaid';
        $paidDate = null;

        if($paidAmount == $grandTotal)
        {
            $paymentStatus = 'paid';
            $paidDate = date('Y-m-d');
        }
        else if($paidAmount < $grandTotal && $paidAmount > 0)
        {
            $paymentStatus = 'partially_paid';
        }
        else
        {
            $paymentStatus = 'unpaid';
        }

        $invoice = Invoice::create([
            'invoice_no' => $invoiceNo,
            'job_id' => $job->id,
            'sub_total' => $subTotal,
            'discount' => $discount,
            'grand_total' => $grandTotal,
            'payment_status' => $paymentStatus,
            'paid_date' => $paidDate,
            'due_date' => $request->due_date,
            'note' => $job->po_no,
        ]);

        Payment::create([
            'invoice_id' => $invoice->id,
            'paid_amount' => $paidAmount,
            'payment_type' => $request->payment_method,
            'cheque_no' => $cheque_no,
            'bank' => $bank,
            'branch' => $branch,
            'cheque_date' => $cheque_date,
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Invoice Created'
        ]);
    }

    // Generate New Invoice Number
    public function generateNewInvoiceNo()
    {
        // Get the last created invoice
        $lastInvoiceNo = Invoice::orderBy('id', 'desc')->first();

        if (!$lastInvoiceNo)
        {
            $number = 0;
        }
        else
        {
            $number = $lastInvoiceNo->id;
        }

        return sprintf('%06d', intval($number) + 1);
    }

    public function addPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|exists:injobs,id',
            'paid_amount' => 'required|numeric',
            'payment_method' => 'required',
    	]);

    	if($validator->fails())
    	{
    		return response()->json(['error' => $validator->errors()], 200);
        }

        if($request->payment_method == 'cheque'){
            $cheque_no = $request->cheque_no;
            $bank = $request->bank;
            $branch = $request->branch;
            $cheque_date = $request->cheque_date;

            if($cheque_no == null){
                return response()->json([
                    'error' => [
                        'message' => ['Cheque No is Empty, Please Enter Cheque No']
                    ],
                    'message' => 'Cheque No is Empty'
                ]);
            }else if($bank == null){
                return response()->json([
                    'error' => [
                        'message' => ['Not Selected Bank, Please Select Bank']
                    ],
                    'message' => 'Not Selected Bank'
                ]);
            }else if($branch == null){
                return response()->json([
                    'error' => [
                        'message' => ['Not Selected Branch, Please Select Branch']
                    ],
                    'message' => 'Not Selected Branch'
                ]);
            }else if($cheque_date == null){
                return response()->json([
                    'error' => [
                        'message' => ['Cheque Date is Empty, Please Enter Cheque Date']
                    ],
                    'message' => 'Cheque Date is Empty'
                ]);
            }
        }else {
            $cheque_no = null;
            $bank = null;
            $branch = null;
            $cheque_date = null;
        }

        $job = Job::find($request->job_id);

        // Check if Job is already Invoiced or Not
        if(!$job->isInvoiced())
        {
            return response()->json([
                'error' => [
                    'message' => ['Job is not invoiced yet']
                ],
                'message' => 'Not Invoiced'
            ]);
        }

        $jobsTotal = $job->jobHasTasks->sum('total');
        $productTotal = $job->jobHasProducts->sum('total');
        $payments = $job->invoice->payments->sum('paid_amount');
        $paidAmount = $request->paid_amount;

        $subTotal = $jobsTotal + $productTotal;
        $discount  = $job->invoice->discount;

        $grandTotal = $subTotal - ($subTotal * ($discount / 100)) - $payments - $paidAmount;

        if($grandTotal == 0)
        {
            // Updating Invoice Payment Status
            $job->invoice->update([
                'payment_status' => 'paid',
                'paid_date' => date('Y-m-d'),
            ]);
        }

        Payment::create([
            'invoice_id' => $job->invoice->id,
            'paid_amount' => $paidAmount,
            'payment_type' => $request->payment_method,
            'cheque_no' => $cheque_no,
            'bank' => $bank,
            'branch' => $branch,
            'cheque_date' => $cheque_date,
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Payment Added'
        ]);
    }

    public function deletePayment($id)
    {
        $payment = Payment::findOrFail($id);

        $invoiceId = $payment->invoice_id;
        $payment->delete();

        $invoice = Invoice::find($invoiceId);

        if($invoice->payments == null)
        {
            $invoice->update([
                'payment_status' => 'unpaid',
            ]);
        }
        else
        {
            $invoice->update([
                'payment_status' => 'partially_paid',
            ]);
        }

        session()->flash('success', 'Payment Removed!');
        return redirect()->back();
    }

    public function print(Request $request)
    {
        $id = $request->payment_id;

        $payment = Payment::with('invoice', 'invoice.job', 'invoice.job.client', 'invoice.job.user', 'invoice.job.jobHasTasks', 'invoice.job.jobHasProducts')->findOrFail($id);
        // dd($payment);
        return view('dashboard.job_management.invoice.print_afoure', [
            'payment' => $payment,
        ]);
    }

    //quick invoice
    public function createQuickInvoice(Request $request)
    {
        $request->validate([
            'total' => 'required',
            'TableData' => 'required',
        ]);

        $total = $request->total;
        $discount = 0;
        $subtotal = $request->subtotal;
        $paid_amount = $request->paid_amount;
        $client = $request->client;

        if(!empty($request->discount)){
            $discount = $subtotal - $total;
        }

        if($paid_amount < $total){
            $paymentStatus = 'partially_paid';
            $invoiceNo = $this->generateNewInvoiceNo();
            $note = "Quick Invoice";
            $payment_type = "cash";

            $invoice = Invoice::create([
                'invoice_no' => $invoiceNo,
                'sub_total' => $subtotal,
                'discount' => $discount,
                'grand_total' => $total,
                'payment_status' => $paymentStatus,
                'note' => $note,
                'client_id' => $client,
            ]);

            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'paid_amount' => $paid_amount,
                'payment_type' => $payment_type,
            ]);
        } else {
            $paymentStatus = 'paid';
            $paidDate = null;
            $paidDate = date('Y-m-d');
            $invoiceNo = $this->generateNewInvoiceNo();
            $note = "Quick Invoice";
            $payment_type = "cash";

            $invoice = Invoice::create([
                'invoice_no' => $invoiceNo,
                'sub_total' => $subtotal,
                'discount' => $discount,
                'grand_total' => $total,
                'payment_status' => $paymentStatus,
                'paid_date' => $paidDate,
                'note' => $note,
                'client_id' => $client,
            ]);

            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'paid_amount' => $paid_amount,
                'payment_type' => $payment_type,
            ]);
        }

        $decodeJsonArray = json_decode($request->TableData, true);

        foreach($decodeJsonArray as $table_data){
            $product_id = $table_data['product_id'];
            $qty = $table_data['product_qty'];
            $stock_count = Stock::where("supplier_product_id", $product_id)->get();

            InvoiceHasProduct::create([
                'invoice_id' => $invoice->id,
                'product_id' => $product_id,
                'qty' => $qty,
                'unit_price' => $table_data['product_price'],
                'description' => $table_data['product_description'],
            ]);

            $product_old_qty = $stock_count[0]->qty;
            $new_qty = $product_old_qty - $qty;
            $stock = Stock::findOrFail($stock_count[0]->id);

            $stock->update([
                'qty' => $new_qty,
            ]);
        }

        return response()->json([
            'error' => false,
            'invoice_id' => $invoice->id,
        ]);
    }

    //quick invoice print
    public function quickPrint($id)
    {
        $invoice = Invoice::findOrFail($id);
        $products = InvoiceHasProduct::with('products','invoice')->where('invoice_id', $id)->get();

        return view('dashboard.job_management.invoice.quick_print',[
            'invoice' => $invoice,
            'products' => $products,
        ]);
    }

    public function getAllQuickInvoice(Request $request)
    {
        $note = "Quick Invoice";
        $invoices = Invoice::with('payments')->where('note','=', $note);

        if($request->invoice_no)
        {
            $invoices->where('invoice_no','=', $request->invoice_no)->where('note','=', $note)->get();
        }
        if($request->client_id)
        {
            $invoices->where('client_id','=', $request->client_id)->where('note','=', $note)->get();
        }
        if($request->invoice_payment_status)
        {
            $invoices->where('payment_status','=', $request->invoice_payment_status)->where('note','=', $note)->get();
        }

        return DataTables::of($invoices)->make();
    }

    public function getAllQuickInvoicePayment($id)
    {
        $invoice = Invoice::findOrFail($id);
        $payments = Payment::with('invoice')->where('invoice_id', $id)->get();
        $client = Client::where('id', $invoice->client_id)->get();
        $products = InvoiceHasProduct::with('products')->where('invoice_id','=',$id)->get();

        return view('dashboard.job_management.invoice.payment',[
            'invoice' => $invoice,
            'payments' => $payments,
            'client' => $client,
            'products' => $products
        ]);
    }

    public function addQuickPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required',
            'paid_amount' => 'required|numeric',
            'payment_method' => 'required',
            'balance' => 'required',
    	]);

    	if($validator->fails())
    	{
    		return response()->json(['error' => $validator->errors()], 200);
        }

        $invoice = Invoice::findOrFail($request->invoice_id);
        $balance = $request->balance;
        $paid_amount = $request->paid_amount;
        $balance = $balance - $paid_amount;

        if($balance == 0)
        {
            // Updating Invoice Payment Status
            $invoice->update([
                'payment_status' => 'paid',
                'paid_date' => date('Y-m-d'),
            ]);
        }
        if($balance > 0)
        {
            // Updating Invoice Payment Status
            $invoice->update([
                'payment_status' => 'partially_paid',
                'paid_date' => date('Y-m-d'),
            ]);
        }

        Payment::create([
            'invoice_id' => $invoice->id,
            'paid_amount' => $paid_amount,
            'payment_type' => $request->payment_method,
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Payment Added'
        ]);
    }
}
