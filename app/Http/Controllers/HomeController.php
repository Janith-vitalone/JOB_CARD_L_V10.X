<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Job;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $controller = explode('@', request()->route()->getAction()['controller'])[0];
//
//        $this->middleware('allowed:' . $controller);
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalRevenue = Payment::sum('paid_amount');
        $totalInvoiced = Invoice::sum('grand_total');
        $todaySale = Payment::whereDate('created_at', Carbon::today())->sum('paid_amount');
        $openJobs = Job::whereDate('created_at', Carbon::today())->where('job_status', 'open')->count();
        $overDueInvoices = Invoice::with('payments', 'job', 'job.client')->whereDate('due_date', '<', Carbon::today())->get();
        $myJobs = Job::with('client')->where('user_id', Auth::user()->id)->where('job_status', 'open')->get();

        return view('dashboard.pages.dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalInvoiced' => $totalInvoiced,
            'todaySale' => $todaySale,
            'openJobs' => $openJobs,
            'overDueInvoices' => $overDueInvoices,
            'myJobs' => $myJobs,
        ]);
    }

    public function dashboard()
    {
        return redirect('/dashboard');
    }
}
