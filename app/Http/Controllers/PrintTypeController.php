<?php

namespace App\Http\Controllers;

use App\PrintType;
use Illuminate\Http\Request;
use DataTables;

class PrintTypeController extends Controller
{

    public function __construct()
    {
        $controller = explode('@', request()->route()->getAction()['controller'])[0];

        $this->middleware('allowed:' . $controller)->only(['index', 'create', 'store', 'update', 'destroy', 'edit', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.utils.print_type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.utils.print_type.create');
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
            'slug' => 'required|string',
            'job_type' => 'required',
            'rate' => 'required',
        ]);

        PrintType::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'job_type' => $request->job_type,
            'rate' => $request->rate,
        ]);

        session()->flash('success', 'Print Type Added!');
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
        $printType = PrintType::findOrFail($id);

        return view('dashboard.utils.print_type.edit', [
            'printType' => $printType,
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
            'slug' => 'required|string',
            'job_type' => 'required',
            'rate' => 'required',
        ]);

        $userRole = PrintType::findOrFail($id);
        $userRole->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'job_type' => $request->job_type,
            'rate' => $request->rate,
        ]);

        session()->flash('success', 'Print Type Updated!');
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
        //
    }

    public function getAllPrintTypes()
    {
        $printTypes = PrintType::all();

        return DataTables::of($printTypes)->make();
    }

    public function getPrintTypeById($id)
    {
        $print_type = PrintType::where('slug', $id)->get();

        return response()->json([
            'error' => false,
            'data' => $print_type,
        ]);
    }
}
