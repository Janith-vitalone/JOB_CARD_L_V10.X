<?php

namespace App\Http\Controllers;

use App\Format;
use Illuminate\Http\Request;
use DataTables;

class FormatController extends Controller
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
        return view('dashboard.utils.format.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.utils.format.create');
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

        Format::create([
            'name' => $request->name,
            'job_type' => $request->job_type,
        ]);

        session()->flash('success', 'Format Added!');
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
        $format = Format::findOrFail($id);

        return view('dashboard.utils.format.edit', [
            'format' => $format,
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

        $format = Format::findOrFail($id);
        $format->update([
            'name' => $request->name,
            'job_type' => $request->job_type,
        ]);

        session()->flash('success', 'Format Updated!');
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
        $format = Format::findOrFail($id);

        $format->delete();

        session()->flash('success', 'Format Removed!');
        return redirect()->back();
    }

    public function getAllFormats()
    {
        $formats = Format::all();

        return DataTables::of($formats)->make();
    }

    public function getFormatByJobType($type)
    {
        $formats = Format::where('job_type', $type)->get();

        return response()->json([
            'error' => false,
            'data' => $formats,
        ]);
    }

    public function getDependableDataById($id)
    {
        $format = Format::with('materials', 'laminations', 'finishings')->findOrFail($id);

        return response()->json([
            'error' => false,
            'data' => $format,
        ]);
    }
}
