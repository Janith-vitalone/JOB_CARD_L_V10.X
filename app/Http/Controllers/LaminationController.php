<?php

namespace App\Http\Controllers;

use App\Lamination;
use Illuminate\Http\Request;
use DataTables;

class LaminationController extends Controller
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
        return view('dashboard.utils.lamination.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.utils.lamination.create');
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
            'rate' => 'required|numeric',
            'job_type' => 'required',
            'format' => 'required',
        ]);

        Lamination::create([
            'name' => $request->name,
            'rate' => $request->rate,
            'job_type' => $request->job_type,
            'format_id' => $request->format,
        ]);

        session()->flash('success', 'Lamination Added!');
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
        $lamination = Lamination::findOrFail($id);

        return view('dashboard.utils.lamination.edit', [
            'lamination' => $lamination,
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
            'rate' => 'required|numeric',
            'job_type' => 'required',
            'format' => 'required',
        ]);

        $lamination = Lamination::findOrFail($id);
        $lamination->update([
            'name' => $request->name,
            'rate' => $request->rate,
            'job_type' => $request->job_type,
            'format_id' => $request->format,
        ]);

        session()->flash('success', 'Lamination Updated!');
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
        $lamination = Lamination::findOrFail($id);

        $lamination->delete();

        session()->flash('success', 'Lamination Removed!');
        return redirect()->back();
    }

    public function getAllLaminations()
    {
        $laminations = Lamination::with('format')->get();

        return DataTables::of($laminations)->make();
    }

    public function getLaminationById($id)
    {
        $lamination = Lamination::findOrFail($id);

        return response()->json([
            'error' => false,
            'data' => $lamination,
        ]);
    }
}
