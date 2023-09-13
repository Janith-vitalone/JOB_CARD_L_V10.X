<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use DataTables;

class MaterialController extends Controller
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
        return view('dashboard.utils.material.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.utils.material.create');
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
            'format' => 'required',
        ]);

        Material::create([
            'name' => $request->name,
            'job_type' => $request->job_type,
            'format_id' => $request->format,
        ]);

        session()->flash('success', 'Material Added!');
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
        $material = Material::with('format')->findOrFail($id);

        return view('dashboard.utils.material.edit', [
            'material' => $material,
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
            'format' => 'required',
        ]);

        $material = Material::findOrFail($id);
        $material->update([
            'name' => $request->name,
            'job_type' => $request->job_type,
            'format_id' => $request->format,
        ]);

        session()->flash('success', 'Material Updated!');
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

    public function getAllMaterials()
    {
        $materials = Material::with('format')->get();

        return DataTables::of($materials)->make();
    }

    public function getMaterialByFormat($id)
    {
        $materials = Material::findOrFail($id);

        return response()->json([
            'error' => false,
            'data' => $materials,
        ]);
    }
}
