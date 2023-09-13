<?php

namespace App\Http\Controllers;

use App\Client;
use App\Quotation;
use App\QuotationHasItem;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use Illuminate\Support\Facades\Auth;
use PDF;
use Mail;
use App\Mail\quotationMail;

class QuotationController extends Controller
{

    public function __construct()
    {
        $controller = explode('@', request()->route()->getAction()['controller'])[0];

        $this->middleware('allowed:' . $controller);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();

        return view('dashboard.job_management.quotation.index', [
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
        return view('dashboard.job_management.quotation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::with('quotationHasItems', 'user', 'client')->findOrFail($id);

        return view('dashboard.job_management.quotation.print', [
            'quote' => $quotation,
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
        $quote = Quotation::with('client', 'quotationHasItems')->findOrFail($id);

        return view('dashboard.job_management.quotation.edit', [
            'quotation' => $quote,
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
        $quote = Quotation::findOrFail($id);

        $quote->delete();

        session()->flash('success', 'Quotation Removed!');
        return redirect()->back();
    }

    public function createQuote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'quote_items' => 'required',
    	]);

    	if($validator->fails())
    	{
    		return response()->json(['error' => $validator->errors()], 200);
        }

        $quoteNo = $this->generateNewQuoteNo();
        $quoteDate = date('Y-m-d');
        $quoteTotal = 0;

        $quote = Quotation::create([
            'client_id' => $request->client_id,
            'quote_no' => $quoteNo,
            'quote_date' => $quoteDate,
            'total' => 0,
            'user_id' => Auth::user()->id,
            'heading' => "quotation",
            'description' => "quotation Description",
        ]);

        foreach($request->quote_items as $item)
        {
            $total = $item['unit_price'] * $item['qty'];
            $quoteTotal += $total;

            $items = QuotationHasItem::create([
                'description' => $item['description'],
                'sub_description' => $item['sub_description'],
                'unit_price' => $item['unit_price'],
                'qty' => $item['qty'],
                'total' => $total,
                'quotation_id' => $quote->id,
            ]);
        }

        $quote->update([
            'total' => $quoteTotal,
        ]);

        $client_details = Client::findOrFail($request->client_id);
        $client_email = $client_details->email;
        //mail
        $quote = Quotation::with('quotationHasItems', 'user', 'client')->findOrFail($quote->id);
        // $emailJobs = new QuotationEmail($quote);
        Mail::to($client_email)
        ->send(new quotationMail($quote));

        return response()->json([
            'error' => false,
            'messsage' => 'Quotation Created',
            'quote_id' => $quote->id,
        ]);
    }

    public function editQuote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quote_items' => 'required',
        ]);

        if($validator->fails())
    	{
    		return response()->json(['error' => $validator->errors()], 200);
        }

        $quoteTotal = 0;

        // Removing current quote items and reinserting
        $quote = Quotation::with('quotationHasItems')->findOrFail($request->id);
        $quote->quotationHasItems()->delete();

        foreach($request->quote_items as $item)
        {
            $total = $item['unit_price'] * $item['qty'];
            $quoteTotal += $total;

            QuotationHasItem::create([
                'description' => $item['description'],
                'sub_description' => $item['sub_description'],
                'unit_price' => $item['unit_price'],
                'qty' => $item['qty'],
                'total' => $total,
                'quotation_id' => $request->id,
            ]);
        }

        $quote->update([
            'total' => $quoteTotal,
        ]);

        $client_details = Client::findOrFail($request->client_id);
        $client_email = $client_details->email;

        return response()->json([
            'error' => false,
            'messsage' => 'Quotation Updated',
            'quote_id' => $quote->id,
        ]);
    }

    // Generate New Quote Number
    public function generateNewQuoteNo()
    {
        // Get the last created job
        $lastQuote = Quotation::orderBy('id', 'desc')->first();

        if (!$lastQuote)
        {
            $number = 17;
        }
        else
        {
            $number = $lastQuote->id;
        }

        return sprintf('%06d', intval($number) + 1);
    }

    public function getAllQuotations(Request $request)
    {
        $quotes = Quotation::with('quotationHasItems', 'client');

        if($request->quote_no)
        {
            $quotes->where('quote_no', $request->quote_no);
        }

        if($request->client_id)
        {
            $quotes->where('client_id', $request->client_id);
        }

        if($request->quote_status)
        {
            $quotes->where('status', $request->quote_status);
        }
        return DataTables::of($quotes->get())->make();
    }

    public function pdf($id)
    {
        $quotation = Quotation::with('quotationHasItems', 'user', 'client')->findOrFail($id);

        $quoteName = 'Quote-' . $quotation->quote_no . '-' . $quotation->client->name . '.pdf';

        PDF::setOptions(['dpi' => 100, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('dashboard.job_management.quotation.pdf', [
            'quote' => $quotation
        ])->setPaper('a4', 'portrait');

        return $pdf->download($quoteName);
    }

    public function changeQuoteStatus($id, $status)
    {
        $quote = Quotation::findOrFail($id);

        $quote->update([
            'status' => $status,
        ]);

        session()->flash('success', 'Quote Status Changed!');
        return redirect()->back();
    }
}
