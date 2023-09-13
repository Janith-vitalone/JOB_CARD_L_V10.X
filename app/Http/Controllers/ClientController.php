<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\Quotation;
use Illuminate\Http\Request;
use DataTables;

class ClientController extends Controller
{

//    public function __construct()
//    {
//        $controller = explode('@', request()->route()->getAction()['controller'])[0];
//
//        $this->middleware('allowed:' . $controller)->only(['index', 'create', 'update', 'destroy', 'edit', 'show']);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'name' => 'required|string',
            'contact_person' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'fax' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Client::create([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'email' => $request->email,
            'fax' => $request->fax,
            'address' => $request->address,
        ]);

        if($request->expectsJson())
        {
            return response()->json([
                'error' => false,
                'message' => 'Client Created'
            ]);
        }

        session()->flash('success', 'Client Added!');
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
        //
    }

    public function getAllClients()
    {
        $clients = Client::get();

        return DataTables::of($clients)->make();
    }

    public function getClientById($id)
    {
        $client = Client::findOrFail($id);
        $unPaidJobs = Invoice::whereIn('payment_status', ['unpaid', 'partially_paid'])->whereHas('job', function($q) use($id) {
            $q->where('client_id', $id);
        })->get();

        $jobs = Job::with('invoice', 'invoice.payments')->where('client_id', $id)->get();

        $overDueAmount = 0;

        foreach($jobs as $inv)
        {
            if ($inv->isInvoiced())
            {
                if(!$inv->isFullyPaid())
                {
                    $total = $inv->invoice->grand_total;
                    $paidAmount = $inv->invoice->payments->sum('paid_amount');
                    $balance = $total - $paidAmount;
                    $overDueAmount += $balance;
                }
            }
            else
            {
                $jobTaskTotal = $inv->jobHasTasks->sum('total');
                $jobProductTotal = $inv->jobHasProducts->sum('total');
                $overDueAmount += ($jobTaskTotal + $jobProductTotal);
            }
        }

        return response()->json([
            'error' => false,
            'data' => $client,
            'pending_payments' => $overDueAmount,
        ]);
    }

    public function getQuotationByClientId($id)
    {
        $quotation = Quotation::where('client_id',$id)->get();

        return response()->json([
            'error' => false,
            'data' => $quotation,
        ]);
    }

    public function getQuotationDetails($id)
    {
        $quotation = Quotation::with('quotationHasItems')->findOrFail($id);
        return response()->json([
            'error' => false,
            'data' => $quotation,
        ]);
    }
}
