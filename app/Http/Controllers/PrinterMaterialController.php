<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Printer;
use Illuminate\Http\Request;
use DataTables;

class PrinterMaterialController extends Controller
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
        return view('dashboard.utils.material_printer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $printers = Printer::get();
        $materials = Material::get();

        return view('dashboard.utils.material_printer.create', [
            'printers' => $printers,
            'materials' => $materials,
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
        $request->validate([
            'printer_id' => 'required|exists:printers,id',
            'materials_id' => 'required',
        ]);

        $materials = Material::find($request->materials_id);

        $printer = Printer::find($request->printer_id);

        $printer->materials()->detach();
        $printer->materials()->attach($materials);

        session()->flash('success', 'Materials Assigned!');
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

    public function getPrinterMaterials()
    {
        $printers = Printer::with('materials');

        return DataTables::eloquent($printers)->toJson();
    }

    public function getPrinterMaterialsById($id)
    {
        $printer = Printer::with('materials')->find($id);

        return response()->json($printer);
    }
}
