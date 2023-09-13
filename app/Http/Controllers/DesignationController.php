<?php

namespace App\Http\Controllers;

use App\Designation;
use Illuminate\Http\Request;
use DataTables;

class DesignationController extends Controller
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
        return view('dashboard.user_management.designation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.user_management.designation.create');
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
        ]);

        Designation::create([
            'name' => $request->name
        ]);

        session()->flash('success', 'Designation Added!');
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
        $designation = Designation::findOrFail($id);

        return view('dashboard.user_management.designation.edit', [
            'designation' => $designation
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
        ]);

        $designation = Designation::findOrFail($id);

        $designation->update([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Designation Updated!');
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
        $designation = Designation::findOrFail($id);

        if($designation->isAssignedToUser())
        {
            session()->flash('warning', 'Unable to remove designation, already assigned to user!');
            return redirect()->back();
        }

        $designation->delete();

        session()->flash('success', 'Designation Removed!');
        return redirect()->back();
    }

    public function getAllDesignations()
    {
        $designations = Designation::all();

        return DataTables::of($designations)->make();
    }
}
