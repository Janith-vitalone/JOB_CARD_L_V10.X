<?php

namespace App\Http\Controllers;

use App\Models\Finishing;
use Illuminate\Http\Request;
use DataTables;

class FinishingController extends Controller
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
        return view('dashboard.utils.finishing.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.utils.finishing.create');
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

        Finishing::create([
            'name' => $request->name,
            'rate' => $request->rate,
            'job_type' => $request->job_type,
            'format_id' => $request->format,
        ]);

        session()->flash('success', 'Finishing Added!');
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
        $finishing = Finishing::findOrFail($id);

        return view('dashboard.utils.finishing.edit', [
            'finishing' => $finishing,
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

        $finishing = Finishing::findOrFail($id);
        $finishing->update([
            'name' => $request->name,
            'rate' => $request->rate,
            'job_type' => $request->job_type,
            'format_id' => $request->format,
        ]);

        session()->flash('success', 'Finishing Updated!');
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
        $finishing = Finishing::findOrFail($id);

        $finishing->delete();

        session()->flash('success', 'Finishing Removed!');
        return redirect()->back();
    }

    public function getAllFinishings()
    {
        $finishings = Finishing::with('format')->get();

        return DataTables::of($finishings)->make();
    }

    public function getFinishingById($id)
    {
        $finishing = Finishing::findOrFail($id);

        return response()->json([
            'error' => false,
            'data' => $finishing,
        ]);
    }
}
