<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;
use DataTables;

class PrinterController extends Controller
{

//    public function __construct()
//    {
//        $controller = explode('@', request()->route()->getAction()['controller'])[0];
//
//        $this->middleware('allowed:' . $controller)->only(['index', 'create', 'store', 'update', 'destroy', 'edit', 'show']);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.utils.printer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.utils.printer.create');
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
            'job_type' => 'required',
        ]);

        Printer::create([
            'name' => $request->name,
            'job_type' => $request->job_type,
        ]);

        session()->flash('success', 'Printer Added!');
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
        $printer = Printer::findOrFail($id);

        return view('dashboard.utils.printer.edit', [
            'printer' => $printer,
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
            'name' => 'required|string',
            'job_type' => 'required',
        ]);

        $printer = Printer::findOrFail($id);
        $printer->update([
            'name' => $request->name,
            'job_type' => $request->job_type,
        ]);

        session()->flash('success', 'Printer Name Updated!');
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
        $printer = Printer::findOrFail($id);

        // Check role has assigned to users
        // if($userRole->isAssignedToUser())
        // {
        //     session()->flash('warning', 'Unable to remove User Role, Already assigned to user!');
        //     return redirect()->back();
        // }

        $printer->delete();

        session()->flash('success', 'Printer Removed!');
        return redirect()->back();
    }

    public function getAllPrinters()
    {
        $printers = Printer::all();

        return DataTables::of($printers)->make();
    }
}
