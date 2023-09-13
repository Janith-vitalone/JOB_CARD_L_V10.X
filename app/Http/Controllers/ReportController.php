<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use App\OtherPayment;
use App\PaymentCategory;
use App\Invoice;
use App\Payment;
use App\StockIn;
use App\Stock;
use App\StockProductCategory;
use App\SupplierProduct;
use App\Supplier;
use App\Client;
use Carbon\Carbon;
use DataTables;

class ReportController extends Controller
{
    public function __construct()
    {
        $controller = explode('@', request()->route()->getAction()['controller'])[0];

        $this->middleware('allowed:' . $controller);
    }

    public function showItemsReport()
    {
        return view('dashboard.reports.items.report');
    }

    public function getItemsReportData(Request $request)
    {
        $jobs = Job::with('client', 'invoice', 'invoice.payments', 'jobHasTasks', 'jobHasProducts');

        $reportData = [];

        $job_no = $request->job_no;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        if($job_no)
        {
            $jobs = $jobs->where('job_no', $job_no)->get();

            foreach($jobs as $key => $item)
            {
                // Adding Job Items
                foreach($item->jobHasProducts as $jobItem)
                {
                    $data = [
                        'id' => $key + 1,
                        'job_no' => $item->job_no,
                        'invoice_no' => $item->isInvoiced() ? $item->invoice->invoice_no : '--',
                        'description' => $jobItem->description,
                        'item' => $jobItem->name,
                        'price' => $jobItem->price,
                        'qty' => $jobItem->qty,
                        'created_at' => $jobItem->created_at->toDateTimeString(),
                        'client' => $item->client->name,
                    ];

                    array_push($reportData, $data);
                }
            }
        }
        else if($from_date != null)
        {
            if($to_date == null){
                $today_date = Carbon::now();
                $today = $today_date->toDateTimeString();

                $jobs = $jobs->whereBetween('created_at',[$from_date, $today])->get();

                foreach($jobs as $key => $item)
                {
                    // Adding Job Items
                    foreach($item->jobHasProducts as $jobItem)
                    {
                        $data = [
                            'id' => $key + 1,
                            'job_no' => $item->job_no,
                            'invoice_no' => $item->isInvoiced() ? $item->invoice->invoice_no : '--',
                            'description' => $jobItem->description,
                            'item' => $jobItem->name,
                            'price' => $jobItem->price,
                            'qty' => $jobItem->qty,
                            'created_at' => $jobItem->created_at->toDateTimeString(),
                            'client' => $item->client->name,
                        ];

                        array_push($reportData, $data);
                    }
                }
            }else{
                $jobs = $jobs->whereBetween('created_at',[$from_date, $to_date])->get();

                foreach($jobs as $key => $item)
                {
                    // Adding Job Items
                    foreach($item->jobHasProducts as $jobItem)
                    {
                        $data = [
                            'id' => $key + 1,
                            'job_no' => $item->job_no,
                            'invoice_no' => $item->isInvoiced() ? $item->invoice->invoice_no : '--',
                            'description' => $jobItem->description,
                            'item' => $jobItem->name,
                            'price' => $jobItem->price,
                            'qty' => $jobItem->qty,
                            'created_at' => $jobItem->created_at->toDateTimeString(),
                            'client' => $item->client->name,
                        ];

                        array_push($reportData, $data);
                    }
                }
            }

        }
        else
        {
            $jobs = $jobs->get();

            foreach($jobs as $key =>  $item)
            {
                // Adding Job Items
                foreach($item->jobHasProducts as $jobItem)
                {
                    $data = [
                        'id' => $key + 1,
                        'job_no' => $item->job_no,
                        'invoice_no' => $item->isInvoiced() ? $item->invoice->invoice_no : '--',
                        'description' => $jobItem->description,
                        'item' => $jobItem->name,
                        'price' => $jobItem->price,
                        'qty' => $jobItem->qty,
                        'created_at' => $jobItem->created_at->toDateTimeString(),
                        'client' => $item->client->name,
                    ];

                    array_push($reportData, $data);
                }
            }
        }

        return DataTables::collection($reportData)->toJson();

    }

    public function showInvoiceReport()
    {
        $clients = Client::all();
        return view('dashboard.reports.invoice.report',compact('clients'));
    }

    public function getInvoiceReportData(Request $request)
    {
        $jobs = Job::with('client', 'invoice', 'invoice.payments', 'jobHasTasks', 'jobHasProducts');

        $reportData = [];

        $invoiced = $request->invoiced != '' ? $request->invoiced : 'fully_paid';
        $job_no = $request->job_no;
        $client = $request->client;
        $from_date = $request->from_date;
        $to_date = $request->to_date;


        // Get invoice information by Job No
        if($job_no)
        {
            $jobs = $jobs->where('job_no', $job_no)->get();

            foreach($jobs as $key => $item)
            {
                $paid = 0;

                if($item->isInvoiced())
                {
                    $paid = $item->invoice->payments->sum('paid_amount');
                }

                if($paid == 0)
                {
                    $data = [
                        'id' => $key+1,
                        'job_no' => $item->job_no,
                        'client' => $item->client->name,
                        'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                        'paid_amount' => '0.00',
                        'due_date' => '--',
                        'invoice_status' => 'not_paid',
                        'last_payment_date' => '--',
                        'invoice_no' => '--',
                        'balance_amount' => '0.00',
                        'created_at' => '--',
                    ];

                    array_push($reportData, $data);
                }
                else
                {
                    $data = [
                        'id' => $key+1,
                        'job_no' => $item->job_no,
                        'client' => $item->client->name,
                        'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                        'paid_amount' => $paid,
                        'due_date' => $item->invoice->due_date,
                        'invoice_status' => $item->invoice->payment_status,
                        'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                        'invoice_no' => $item->invoice->invoice_no,
                        'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                        'created_at' => $item->invoice->created_at->toDateTimeString(),
                    ];

                    array_push($reportData, $data);
                }
            }

            return DataTables::collection($reportData)->toJson();
        }

        if($invoiced === 'fully_paid')
        {
            //check selcet client
            if($client != 'all'){
                //check date renge value
                if($from_date != null ){
                    if($to_date == null ){
                        $today_date = Carbon::now();
                        $today = $today_date->toDateTimeString();

                        $jobs = $jobs->whereHas('invoice', function($q) {
                            $q->where('deleted_at', null);
                        })->where('client_id', $client)->whereBetween('created_at',[$from_date, $today])->get();
                    }else{
                        $jobs = $jobs->whereHas('invoice', function($q) {
                            $q->where('deleted_at', null);
                        })->where('client_id', $client)->whereBetween('created_at',[$from_date, $to_date])->get();
                    }

                    foreach($jobs as $key => $item)
                    {
                        $paid = $item->invoice->payments->sum('paid_amount');
                        if($paid > 0 && $item->invoice->payment_status === 'paid')
                        {
                            $data = [
                                'id' => $key+1,
                                'job_no' => $item->job_no,
                                'client' => $item->client->name,
                                'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                                'paid_amount' => $paid,
                                'due_date' => $item->invoice->due_date,
                                'invoice_status' => $item->invoice->payment_status,
                                'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                                'invoice_no' => $item->invoice->invoice_no,
                                'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                                'created_at' => $item->invoice->created_at->toDateTimeString(),
                            ];

                            array_push($reportData, $data);
                        }
                    }

                    return DataTables::collection($reportData)->toJson();
                }

                $jobs = $jobs->whereHas('invoice', function($q) {
                    $q->where('deleted_at', null);
                })->where('client_id', $client)->get();

                foreach($jobs as $key => $item)
                {
                    $paid = $item->invoice->payments->sum('paid_amount');

                    if($paid > 0 && $item->invoice->payment_status === 'paid')
                    {
                        $data = [
                            'id' => $key+1,
                            'job_no' => $item->job_no,
                            'client' => $item->client->name,
                            'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                            'paid_amount' => $paid,
                            'due_date' => $item->invoice->due_date,
                            'invoice_status' => $item->invoice->payment_status,
                            'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                            'invoice_no' => $item->invoice->invoice_no,
                            'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                            'created_at' => $item->invoice->created_at->toDateTimeString(),
                        ];

                        array_push($reportData, $data);
                    }
                }

                return DataTables::collection($reportData)->toJson();
            }

            if($from_date != null){
                if($to_date == null ){
                    $today_date = Carbon::now();
                    $today = $today_date->toDateTimeString();

                    $jobs = $jobs->whereHas('invoice', function($q) {
                        $q->where('deleted_at', null);
                    })->whereBetween('created_at',[$from_date, $today])->get();
                }else{
                    $jobs = $jobs->whereHas('invoice', function($q) {
                        $q->where('deleted_at', null);
                    })->whereBetween('created_at',[$from_date, $to_date])->get();
                }

                foreach($jobs as $key => $item)
                {
                    $paid = $item->invoice->payments->sum('paid_amount');
                    if($paid > 0 && $item->invoice->payment_status === 'paid')
                    {
                        $data = [
                            'id' => $key+1,
                            'job_no' => $item->job_no,
                            'client' => $item->client->name,
                            'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                            'paid_amount' => $paid,
                            'due_date' => $item->invoice->due_date,
                            'invoice_status' => $item->invoice->payment_status,
                            'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                            'invoice_no' => $item->invoice->invoice_no,
                            'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                            'created_at' => $item->invoice->created_at->toDateTimeString(),
                        ];

                        array_push($reportData, $data);
                    }
                }

                return DataTables::collection($reportData)->toJson();
            }

            $jobs = $jobs->whereHas('invoice', function($q) {
                $q->where('deleted_at', null);
            })->get();

            foreach($jobs as $key => $item)
            {
                $paid = $item->invoice->payments->sum('paid_amount');

                if($paid > 0 && $item->invoice->payment_status === 'paid')
                {
                    $data = [
                        'id' => $key+1,
                        'job_no' => $item->job_no,
                        'client' => $item->client->name,
                        'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                        'paid_amount' => $paid,
                        'due_date' => $item->invoice->due_date,
                        'invoice_status' => $item->invoice->payment_status,
                        'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                        'invoice_no' => $item->invoice->invoice_no,
                        'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                        'created_at' => $item->invoice->created_at->toDateTimeString(),
                    ];

                    array_push($reportData, $data);
                }
            }

            return DataTables::collection($reportData)->toJson();
        }
        else if($invoiced === 'partially_paid')
        {

            //check selcet client
            if($client != 'all'){
                //check date renge value
                if($from_date != null ){
                    if($to_date == null ){
                        $today_date = Carbon::now();
                        $today = $today_date->toDateTimeString();

                        $jobs = $jobs->whereHas('invoice', function($q) {
                            $q->where('deleted_at', null);
                        })->where('client_id', $client)->whereBetween('created_at',[$from_date, $today])->get();
                    }else{
                        $jobs = $jobs->whereHas('invoice', function($q) {
                            $q->where('deleted_at', null);
                        })->where('client_id', $client)->whereBetween('created_at',[$from_date, $to_date])->get();
                    }

                    foreach($jobs as $key => $item)
                    {
                        $paid = $item->invoice->payments->sum('paid_amount');
                        if($paid > 0 && $item->invoice->payment_status === 'partially_paid')
                        {
                            $data = [
                                'id' => $key+1,
                                'job_no' => $item->job_no,
                                'client' => $item->client->name,
                                'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                                'paid_amount' => $paid,
                                'due_date' => $item->invoice->due_date,
                                'invoice_status' => $item->invoice->payment_status,
                                'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                                'invoice_no' => $item->invoice->invoice_no,
                                'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                                'created_at' => $item->invoice->created_at->toDateTimeString(),
                            ];

                            array_push($reportData, $data);
                        }
                    }

                    return DataTables::collection($reportData)->toJson();
                }

                $jobs = $jobs->whereHas('invoice', function($q) {
                    $q->where('deleted_at', null);
                })->where('client_id', $client)->get();

                foreach($jobs as $key => $item)
                {
                    $paid = $item->invoice->payments->sum('paid_amount');

                    if($paid > 0 && $item->invoice->payment_status === 'partially_paid')
                    {
                        $data = [
                            'id' => $key+1,
                            'job_no' => $item->job_no,
                            'client' => $item->client->name,
                            'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                            'paid_amount' => $paid,
                            'due_date' => $item->invoice->due_date,
                            'invoice_status' => $item->invoice->payment_status,
                            'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                            'invoice_no' => $item->invoice->invoice_no,
                            'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                            'created_at' => $item->invoice->created_at->toDateTimeString(),
                        ];

                        array_push($reportData, $data);
                    }
                }

                return DataTables::collection($reportData)->toJson();
            }

            if($from_date != null){
                if($to_date == null ){
                    $today_date = Carbon::now();
                    $today = $today_date->toDateTimeString();

                    $jobs = $jobs->whereHas('invoice', function($q) {
                        $q->where('deleted_at', null);
                    })->whereBetween('created_at',[$from_date, $today])->get();
                }else{
                    $jobs = $jobs->whereHas('invoice', function($q) {
                        $q->where('deleted_at', null);
                    })->whereBetween('created_at',[$from_date, $to_date])->get();
                }

                foreach($jobs as $key => $item)
                {
                    $paid = $item->invoice->payments->sum('paid_amount');
                    if($paid > 0 && $item->invoice->payment_status === 'partially_paid')
                    {
                        $data = [
                            'id' => $key+1,
                            'job_no' => $item->job_no,
                            'client' => $item->client->name,
                            'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                            'paid_amount' => $paid,
                            'due_date' => $item->invoice->due_date,
                            'invoice_status' => $item->invoice->payment_status,
                            'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                            'invoice_no' => $item->invoice->invoice_no,
                            'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                            'created_at' => $item->invoice->created_at->toDateTimeString(),
                        ];

                        array_push($reportData, $data);
                    }
                }

                return DataTables::collection($reportData)->toJson();
            }
            
            $jobs = $jobs->whereHas('invoice', function($q) {
                $q->where('deleted_at', null);
            })->get();

            foreach($jobs as $key => $item)
            {
                $paid = $item->invoice->payments->sum('paid_amount');

                if($paid > 0 && $item->invoice->payment_status === 'partially_paid')
                {
                    $data = [
                        'id' => $key+1,
                        'job_no' => $item->job_no,
                        'client' => $item->client->name,
                        'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                        'paid_amount' => $paid,
                        'due_date' => $item->invoice->due_date,
                        'invoice_status' => $item->invoice->payment_status,
                        'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                        'invoice_no' => $item->invoice->invoice_no,
                        'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                        'created_at' => $item->invoice->created_at->toDateTimeString(),
                    ];

                    array_push($reportData, $data);
                }
            }

            return DataTables::collection($reportData)->toJson();
        }
        else if($invoiced === 'not_paid')
        {
            $jobs = $jobs->get();

            foreach($jobs as $key => $item)
            {
                $paid = 0;

                if($item->isInvoiced())
                {
                    $paid = $item->invoice->payments->sum('paid_amount');
                }

                if($paid == 0)
                {
                    $data = [
                        'id' => $key+1,
                        'job_no' => $item->job_no,
                        'client' => $item->client->name,
                        'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                        'paid_amount' => '0.00',
                        'due_date' => '--',
                        'invoice_status' => 'not_paid',
                        'last_payment_date' => '--',
                        'invoice_no' => '--',
                        'balance_amount' => '0.00',
                        'created_at' => '--',
                    ];

                    array_push($reportData, $data);
                }
            }

            return DataTables::collection($reportData)->toJson();
        }
        else
        {
            if($client != 'all'){
                if($from_date != null){
                    if($to_date == null ){
                        $today_date = Carbon::now();
                        $today = $today_date->toDateTimeString();

                        $jobs = $jobs->where('client_id', $client)->whereBetween('created_at',[$from_date, $today])->get();
                    }else{
                        $jobs = $jobs->where('client_id', $client)->whereBetween('created_at',[$from_date, $to_date])->get();
                    }

                    foreach($jobs as $key => $item)
                    {
                        $paid = 0;
        
                        if($item->isInvoiced())
                        {
                            $paid = $item->invoice->payments->sum('paid_amount');
        
                            $data = [
                                'id' => $key+1,
                                'job_no' => $item->job_no,
                                'client' => $item->client->name,
                                'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                                'paid_amount' => $paid,
                                'due_date' => $item->invoice->due_date,
                                'invoice_status' => $item->invoice->payment_status,
                                'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                                'invoice_no' => $item->invoice->invoice_no,
                                'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                                'created_at' => $item->invoice->created_at->toDateTimeString(),
                            ];
        
                            array_push($reportData, $data);
                        }
                        else
                        {
                            $data = [
                                'id' => $key+1,
                                'job_no' => $item->job_no,
                                'client' => $item->client->name,
                                'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                                'paid_amount' => '0.00',
                                'due_date' => '--',
                                'invoice_status' => 'not_paid',
                                'last_payment_date' => '--',
                                'invoice_no' => '--',
                                'balance_amount' => '0.00',
                                'created_at' => '--',
                            ];
        
                            array_push($reportData, $data);
                        }
                    }
        
                    return DataTables::collection($reportData)->toJson();
                }
                $jobs = $jobs->where('client_id', $client)->get();

                foreach($jobs as $key => $item)
                {
                    $paid = 0;
    
                    if($item->isInvoiced())
                    {
                        $paid = $item->invoice->payments->sum('paid_amount');
    
                        $data = [
                            'id' => $key+1,
                            'job_no' => $item->job_no,
                            'client' => $item->client->name,
                            'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                            'paid_amount' => $paid,
                            'due_date' => $item->invoice->due_date,
                            'invoice_status' => $item->invoice->payment_status,
                            'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                            'invoice_no' => $item->invoice->invoice_no,
                            'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                            'created_at' => $item->invoice->created_at->toDateTimeString(),
                        ];
    
                        array_push($reportData, $data);
                    }
                    else
                    {
                        $data = [
                            'id' => $key+1,
                            'job_no' => $item->job_no,
                            'client' => $item->client->name,
                            'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                            'paid_amount' => '0.00',
                            'due_date' => '--',
                            'invoice_status' => 'not_paid',
                            'last_payment_date' => '--',
                            'invoice_no' => '--',
                            'balance_amount' => '0.00',
                            'created_at' => '--',
                        ];
    
                        array_push($reportData, $data);
                    }
                }
    
                return DataTables::collection($reportData)->toJson();
            }

            if($from_date != null){
                if($to_date == null ){
                    $today_date = Carbon::now();
                    $today = $today_date->toDateTimeString();

                    $jobs = $jobs->whereBetween('created_at',[$from_date, $today])->get();
                }else{
                    $jobs = $jobs->whereBetween('created_at',[$from_date, $to_date])->get();
                }

                foreach($jobs as $key => $item)
                {
                    $paid = 0;
    
                    if($item->isInvoiced())
                    {
                        $paid = $item->invoice->payments->sum('paid_amount');
    
                        $data = [
                            'id' => $key+1,
                            'job_no' => $item->job_no,
                            'client' => $item->client->name,
                            'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                            'paid_amount' => $paid,
                            'due_date' => $item->invoice->due_date,
                            'invoice_status' => $item->invoice->payment_status,
                            'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                            'invoice_no' => $item->invoice->invoice_no,
                            'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                            'created_at' => $item->invoice->created_at->toDateTimeString(),
                        ];
    
                        array_push($reportData, $data);
                    }
                    else
                    {
                        $data = [
                            'id' => $key+1,
                            'job_no' => $item->job_no,
                            'client' => $item->client->name,
                            'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                            'paid_amount' => '0.00',
                            'due_date' => '--',
                            'invoice_status' => 'not_paid',
                            'last_payment_date' => '--',
                            'invoice_no' => '--',
                            'balance_amount' => '0.00',
                            'created_at' => '--',
                        ];
    
                        array_push($reportData, $data);
                    }
                }
    
                return DataTables::collection($reportData)->toJson();
            }

            $jobs = $jobs->get();

            foreach($jobs as $key => $item)
            {
                $paid = 0;

                if($item->isInvoiced())
                {
                    $paid = $item->invoice->payments->sum('paid_amount');

                    $data = [
                        'id' => $key+1,
                        'job_no' => $item->job_no,
                        'client' => $item->client->name,
                        'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                        'paid_amount' => $paid,
                        'due_date' => $item->invoice->due_date,
                        'invoice_status' => $item->invoice->payment_status,
                        'last_payment_date' => $item->invoice->payments->last()->created_at->toDateTimeString(),
                        'invoice_no' => $item->invoice->invoice_no,
                        'balance_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total') - $paid,
                        'created_at' => $item->invoice->created_at->toDateTimeString(),
                    ];

                    array_push($reportData, $data);
                }
                else
                {
                    $data = [
                        'id' => $key+1,
                        'job_no' => $item->job_no,
                        'client' => $item->client->name,
                        'total_amount' => $item->jobHasTasks->sum('total') + $item->jobHasProducts->sum('total'),
                        'paid_amount' => '0.00',
                        'due_date' => '--',
                        'invoice_status' => 'not_paid',
                        'last_payment_date' => '--',
                        'invoice_no' => '--',
                        'balance_amount' => '0.00',
                        'created_at' => '--',
                    ];

                    array_push($reportData, $data);
                }
            }

            return DataTables::collection($reportData)->toJson();
        }
    }

    public function showOtherPaymentReport()
    {
        $categories = PaymentCategory::all();
        return view('dashboard.reports.other_payment.report', compact('categories'));
    }

    public function getOtherPaymentReportData(Request $request)
    {   
        $reportData = [];

        $payment_category = $request->payment_category;
        // $job_no = $request->job_no;

        $from = date($request->from);
        $to = date($request->to);
        if(!empty($from))
        {
            if(!empty($to)){
                $payments = OtherPayment::whereBetween('created_at',[$from, $to]);

                $payments = $payments->get();

                foreach($payments as $key => $payment)
                {
                    $data = [
                        'id' => $key+1,
                        'category' => $payment->paymentCategory->category,
                        'bank' => $payment->bank,
                        'description'=> $payment->description,
                        'cheque_no' => $payment->cheque_no,
                        'banking_date' => $payment->banking_date,
                        'amount' => $payment->amount,
                        'created_at' => $payment->created_at,
                    ];

                    array_push($reportData, $data);
                }
                return DataTables::collection($reportData)->toJson();
            } 
            
            $today = Carbon::now();
            $today = $today->toDateString();
            $payments = OtherPayment::whereBetween('created_at',[$from,$today]);

            $payments = $payments->get();

                foreach($payments as $key => $payment)
                {
                    $data = [
                        'id' => $key+1,
                        'category' => $payment->paymentCategory->category,
                        'bank' => $payment->bank,
                        'description'=> $payment->description,
                        'cheque_no' => $payment->cheque_no,
                        'banking_date' => $payment->banking_date,
                        'amount' => $payment->amount,
                        'created_at' => $payment->created_at,
                    ];

                    array_push($reportData, $data);
                }
                return DataTables::collection($reportData)->toJson();
        }

        if($payment_category == "all"){

            $payments = OtherPayment::with('paymentCategory');
            $payments = $payments->get();

            foreach($payments as $key => $payment)
            {
                $data = [
                    'id' => $key+1,
                    'category' => $payment->paymentCategory->category,
                    'bank' => $payment->bank,
                    'description'=> $payment->description,
                    'cheque_no' => $payment->cheque_no,
                    'banking_date' => $payment->banking_date,
                    'amount' => $payment->amount,
                    'created_at' => $payment->created_at,
                ];

                array_push($reportData, $data);
            }
            return DataTables::collection($reportData)->toJson();
        }
        else if(!empty($payment_category))
        {
            $payments = OtherPayment::where('paymentCategories_id', $payment_category)->with('paymentCategory');
            $payments = $payments->get();

            foreach($payments as $key => $payment)
            {
                $data = [
                    'id' => $key+1,
                    'category' => $payment->paymentCategory->category,
                    'bank' => $payment->bank,
                    'description'=> $payment->description,
                    'cheque_no' => $payment->cheque_no,
                    'banking_date' => $payment->banking_date,
                    'amount' => $payment->amount,
                    'created_at' => $payment->created_at,
                ];

                array_push($reportData, $data);
            }
            return DataTables::collection($reportData)->toJson();
        }
    }

    public function showProfitAndLossreport()
    {
        $categories = PaymentCategory::all();
        return view('dashboard.reports.profitandloss.report', compact('categories'));
    }

    public function generatepnl(Request $request)
    {
        $request->validate([
            'from' => 'required'
        ]);

        $from  = $request->from;

        if(!empty($request->to))
        {
            $to = $request->to;
        }
        else
        {
            $to = Carbon::today()->toDateString();
        }

        $income = Payment::whereBetween('created_at', [$from, $to])->sum('paid_amount');

        $company_expense = StockIn::whereBetween('created_at', [$from, $to])->sum('total');

        $other_payment = OtherPayment::whereBetween('created_at', [$from, $to])->sum('amount');

        $expense = $company_expense + $other_payment;

        return view('dashboard.reports.profitandloss.generatepnl', [
            'income' => $income,
            'expense' => $expense,
            'from_date' => $from,
            'to_date' => $to,
        ]);
    }

    public function generatepnlTable(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to' =>'required'
        ]);

        $from = $request->from;
        $to = $request->to;
        $reportData = [];

        $income = Payment::whereBetween('created_at', [$from, $to])->sum('paid_amount');
        $company_expense = StockIn::whereBetween('created_at', [$from, $to])->sum('total');
        $other_payment = OtherPayment::whereBetween('created_at', [$from, $to])->sum('amount');

        $expense = number_format($company_expense + $other_payment, 2, '.', '');

        $total_income = $income - $expense;
        

        if(!empty($income))
        {
            $data = [
                'id' => 1,
                'name' => "Revenues",
                'single' => "",
                'total'=> "",
            ];

            array_push($reportData, $data);

            $data = [
                'id' => 2,
                'name' => "Sales",
                'single' => number_format($income, 2, '.', ''),
                'total'=> "",
            ];

            array_push($reportData, $data);

            $data = [
                'id' => 3,
                'name' => "Total Revenues",
                'single' => "",
                'total'=> number_format($income, 2, '.', ''),
            ];

            array_push($reportData, $data);
        }

        if(!empty($company_expense))
        {
            $data = [
                'id' => 4,
                'name' => "Expenses",
                'single' => "",
                'total'=> "",
            ];

            array_push($reportData, $data);

            $data = [
                'id' => 5,
                'name' => "Cost of buying",
                'single' => number_format($company_expense, 2, '.', ''),
                'total'=> "",
            ];

            array_push($reportData, $data);
        }

        if(!empty($other_payment))
        {

            $data = [
                'id' => 6,
                'name' => "Other payments",
                'single' => number_format($other_payment, 2, '.', ''),
                'total'=> "",
            ];

            array_push($reportData, $data);
        }

        $data = [
            'id' => 7,
            'name' => "Total Expenses",
            'single' => "",
            'total'=> number_format($expense, 2, '.', ''),
        ];
        array_push($reportData, $data);

        $data = [
            'id' => 8,
            'name' => "Total Income",
            'single' => "",
            'total'=> number_format($total_income, 2, '.', ''),
        ];
        array_push($reportData, $data);

        return DataTables::collection($reportData)->toJson();
    }

    public function showQuickInvoiceReport()
    {
        return view('dashboard.reports.quick_invoice.report');
    }

    public function getQuickInvoiceReportData(Request $request)
    {
        $invoices = Invoice::with('client','payments')->where('note', '=', 'Quick Invoice');

        $invoice_no = $request->job_no;
        $invoiced = $request->invoiced;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $reportData = [];

        // Get invoice information by Invoice No
        if($invoice_no)
        {
            $invoices = $invoices->where('invoice_no', $invoice_no)->get();

            foreach($invoices as $key => $invoice)
            {
                $paid = 0;
                $paid = $invoice->payments->sum('paid_amount');

                if($paid == 0)
                {
                    $data = [
                        'id' => $key+1,
                        'invoice_no' => $invoice->invoice_no,
                        'client' => $invoice->client->name,
                        'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                        'paid_amount' => '0.00',
                        'invoice_status' => 'not_paid',
                        'last_payment_date' => '--',
                        'balance_amount' => '0.00',
                        'created_at' => '--',
                    ];

                    array_push($reportData, $data);
                } else {
                    $data = [
                        'id' => $key+1,
                        'invoice_no' => $invoice->invoice_no,
                        'client' => $invoice->client->name,
                        'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                        'paid_amount' => number_format($paid, 2, '.', ''),
                        'invoice_status' => $invoice->payment_status,
                        'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                        'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                        'created_at' => $invoice->created_at->toDateTimeString(),
                    ];

                    array_push($reportData, $data);
                }
            }
            return DataTables::collection($reportData)->toJson();
        }

        if($invoiced === 'paid')
        {
            if($from_date != null){
                if($to_date == null){
                    $today_date = Carbon::now();
                    $today = $today_date->toDateTimeString();

                    $invoices = $invoices->where('payment_status', $invoiced)->whereBetween('created_at',[$from_date,$today])->get();

                    foreach($invoices as $key => $invoice)
                    {
                        $paid = 0;
                        $paid = $invoice->payments->sum('paid_amount');
                        
                        $data = [
                            'id' => $key+1,
                            'invoice_no' => $invoice->invoice_no,
                            'client' => $invoice->client->name,
                            'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                            'paid_amount' => number_format($paid, 2, '.', ''),
                            'invoice_status' => $invoice->payment_status,
                            'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                            'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                            'created_at' => $invoice->created_at->toDateTimeString(),
                        ];
                        
                        array_push($reportData, $data);
                    } 
                }else{
                    $invoices = $invoices->where('payment_status', $invoiced)->whereBetween('created_at',[$from_date,$to_date])->get();

                    foreach($invoices as $key => $invoice)
                    {
                        $paid = 0;
                        $paid = $invoice->payments->sum('paid_amount');
                        
                        $data = [
                            'id' => $key+1,
                            'invoice_no' => $invoice->invoice_no,
                            'client' => $invoice->client->name,
                            'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                            'paid_amount' => number_format($paid, 2, '.', ''),
                            'invoice_status' => $invoice->payment_status,
                            'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                            'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                            'created_at' => $invoice->created_at->toDateTimeString(),
                        ];
                        
                        array_push($reportData, $data);
                    } 
                }

            }else{
                $invoices = $invoices->where('payment_status', $invoiced)->get();

                foreach($invoices as $key => $invoice)
                {
                    $paid = 0;
                    $paid = $invoice->payments->sum('paid_amount');
                    
                    $data = [
                        'id' => $key+1,
                        'invoice_no' => $invoice->invoice_no,
                        'client' => $invoice->client->name,
                        'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                        'paid_amount' => number_format($paid, 2, '.', ''),
                        'invoice_status' => $invoice->payment_status,
                        'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                        'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                        'created_at' => $invoice->created_at->toDateTimeString(),
                    ];
                    
                    array_push($reportData, $data);
                } 
            }
            return DataTables::collection($reportData)->toJson();
        }
        else if($invoiced === 'partially_paid')
        {
            if($from_date != null){
                if($to_date == null){
                    $today_date = Carbon::now();
                    $today = $today_date->toDateTimeString();

                    $invoices = $invoices->where('payment_status', $invoiced)->whereBetween('created_at',[$from_date,$today])->get();

                    foreach($invoices as $key => $invoice)
                    {
                        $paid = 0;
                        $paid = $invoice->payments->sum('paid_amount');
                        
                        $data = [
                            'id' => $key+1,
                            'invoice_no' => $invoice->invoice_no,
                            'client' => $invoice->client->name,
                            'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                            'paid_amount' => number_format($paid, 2, '.', ''),
                            'invoice_status' => $invoice->payment_status,
                            'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                            'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                            'created_at' => $invoice->created_at->toDateTimeString(),
                        ];
                        
                        array_push($reportData, $data);
                    } 
                }else{
                    $invoices = $invoices->where('payment_status', $invoiced)->whereBetween('created_at',[$from_date,$to_date])->get();

                    foreach($invoices as $key => $invoice)
                    {
                        $paid = 0;
                        $paid = $invoice->payments->sum('paid_amount');
                        
                        $data = [
                            'id' => $key+1,
                            'invoice_no' => $invoice->invoice_no,
                            'client' => $invoice->client->name,
                            'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                            'paid_amount' => number_format($paid, 2, '.', ''),
                            'invoice_status' => $invoice->payment_status,
                            'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                            'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                            'created_at' => $invoice->created_at->toDateTimeString(),
                        ];
                        
                        array_push($reportData, $data);
                    } 
                }
            }else{
                $invoices = $invoices->where('payment_status', $invoiced)->get();
            
                foreach($invoices as $key => $invoice)
                {
                    $paid = 0;
                    $paid = $invoice->payments->sum('paid_amount');
                    
                    $data = [
                        'id' => $key+1,
                        'invoice_no' => $invoice->invoice_no,
                        'client' => $invoice->client->name,
                        'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                        'paid_amount' => number_format($paid, 2, '.', ''),
                        'invoice_status' => $invoice->payment_status,
                        'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                        'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                        'created_at' => $invoice->created_at->toDateTimeString(),
                    ];
                    
                    array_push($reportData, $data);
                } 
            }
            return DataTables::collection($reportData)->toJson();
        }
        else if($invoiced === 'unpaid')
        {
            if($from_date != null){
                if($to_date == null){
                    $today_date = Carbon::now();
                    $today = $today_date->toDateTimeString();

                    $invoices = $invoices->where('payment_status', $invoiced)->whereBetween('created_at',[$from_date,$today])->get();

                    foreach($invoices as $key => $invoice)
                    {
                        $paid = 0;
                        $paid = $invoice->payments->sum('paid_amount');
                        
                        $data = [
                            'id' => $key+1,
                            'invoice_no' => $invoice->invoice_no,
                            'client' => $invoice->client->name,
                            'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                            'paid_amount' => number_format($paid, 2, '.', ''),
                            'invoice_status' => $invoice->payment_status,
                            'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                            'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                            'created_at' => $invoice->created_at->toDateTimeString(),
                        ];
                        
                        array_push($reportData, $data);
                    } 
                }else{
                    $invoices = $invoices->where('payment_status', $invoiced)->whereBetween('created_at',[$from_date,$to_date])->get();

                    foreach($invoices as $key => $invoice)
                    {
                        $paid = 0;
                        $paid = $invoice->payments->sum('paid_amount');
                        
                        $data = [
                            'id' => $key+1,
                            'invoice_no' => $invoice->invoice_no,
                            'client' => $invoice->client->name,
                            'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                            'paid_amount' => number_format($paid, 2, '.', ''),
                            'invoice_status' => $invoice->payment_status,
                            'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                            'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                            'created_at' => $invoice->created_at->toDateTimeString(),
                        ];
                        
                        array_push($reportData, $data);
                    } 
                }
            }else{
                $invoices = $invoices->where('payment_status', $invoiced)->get();
            
                foreach($invoices as $key => $invoice)
                {
                    $paid = 0;
                    $paid = $invoice->payments->sum('paid_amount');
                    
                    $data = [
                        'id' => $key+1,
                        'invoice_no' => $invoice->invoice_no,
                        'client' => $invoice->client->name,
                        'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                        'paid_amount' => number_format($paid, 2, '.', ''),
                        'invoice_status' => $invoice->payment_status,
                        'last_payment_date' => '--',
                        'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                        'created_at' => $invoice->created_at->toDateTimeString(),
                    ];
                    
                    array_push($reportData, $data);
                } 
            }
            return DataTables::collection($reportData)->toJson();
        }
        else 
        {
            if($from_date != null){
                if($to_date == null){
                    $today_date = Carbon::now();
                    $today = $today_date->toDateTimeString();

                    $invoices = $invoices->whereBetween('created_at',[$from_date,$today])->get();

                    foreach($invoices as $key => $invoice)
                    {
                        $paid = 0;
                        $paid = $invoice->payments->sum('paid_amount');

                        if($paid == 0)
                        {
                            $data = [
                                'id' => $key+1,
                                'invoice_no' => $invoice->invoice_no,
                                'client' => $invoice->client->name,
                                'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                                'paid_amount' => '0.00',
                                'invoice_status' => 'not_paid',
                                'last_payment_date' => '--',
                                'balance_amount' => '0.00',
                                'created_at' => $invoice->created_at->toDateTimeString(),
                            ];

                            array_push($reportData, $data);
                        } else {
                            $data = [
                                'id' => $key+1,
                                'invoice_no' => $invoice->invoice_no,
                                'client' => $invoice->client->name,
                                'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                                'paid_amount' => number_format($paid, 2, '.', ''),
                                'invoice_status' => $invoice->payment_status,
                                'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                                'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                                'created_at' => $invoice->created_at->toDateTimeString(),
                            ];

                            array_push($reportData, $data);
                        }
                    }
                }else{
                    $invoices = $invoices->whereBetween('created_at',[$from_date,$to_date])->get();

                    foreach($invoices as $key => $invoice)
                    {
                        $paid = 0;
                        $paid = $invoice->payments->sum('paid_amount');

                        if($paid == 0)
                        {
                            $data = [
                                'id' => $key+1,
                                'invoice_no' => $invoice->invoice_no,
                                'client' => $invoice->client->name,
                                'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                                'paid_amount' => '0.00',
                                'invoice_status' => 'not_paid',
                                'last_payment_date' => '--',
                                'balance_amount' => '0.00',
                                'created_at' => $invoice->created_at->toDateTimeString(),
                            ];

                            array_push($reportData, $data);
                        } else {
                            $data = [
                                'id' => $key+1,
                                'invoice_no' => $invoice->invoice_no,
                                'client' => $invoice->client->name,
                                'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                                'paid_amount' => number_format($paid, 2, '.', ''),
                                'invoice_status' => $invoice->payment_status,
                                'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                                'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                                'created_at' => $invoice->created_at->toDateTimeString(),
                            ];

                            array_push($reportData, $data);
                        }
                    }
                }
            }else{
                $invoices = $invoices->get();

                foreach($invoices as $key => $invoice)
                {
                    $paid = 0;
                    $paid = $invoice->payments->sum('paid_amount');

                    if($paid == 0)
                    {
                        $data = [
                            'id' => $key+1,
                            'invoice_no' => $invoice->invoice_no,
                            'client' => $invoice->client->name,
                            'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                            'paid_amount' => '0.00',
                            'invoice_status' => 'not_paid',
                            'last_payment_date' => '--',
                            'balance_amount' => '0.00',
                            'created_at' => $invoice->created_at->toDateTimeString(),
                        ];

                        array_push($reportData, $data);
                    } else {
                        $data = [
                            'id' => $key+1,
                            'invoice_no' => $invoice->invoice_no,
                            'client' => $invoice->client->name,
                            'total_amount' => number_format($invoice->grand_total, 2, '.', ''),
                            'paid_amount' => number_format($paid, 2, '.', ''),
                            'invoice_status' => $invoice->payment_status,
                            'last_payment_date' => $invoice->payments->last()->created_at->toDateTimeString(),
                            'balance_amount' => number_format($invoice->grand_total - $paid, 2, '.', ''),
                            'created_at' => $invoice->created_at->toDateTimeString(),
                        ];

                        array_push($reportData, $data);
                    }
                }
            }
            return DataTables::collection($reportData)->toJson();
        }
        
    }

    public function showStockReport()
    {
        $categories = StockProductCategory::all();

        return view('dashboard.reports.stock.report', [
            'categories' => $categories,
        ]);
    }

    public function getStockReportData(Request $request)
    {
        $reportData = Stock::with('stockProductCategory', 'product')->get();
        return DataTables::collection($reportData)->toJson();
    }
}
