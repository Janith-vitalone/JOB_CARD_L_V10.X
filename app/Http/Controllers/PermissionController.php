<?php

namespace App\Http\Controllers;

use App\Form;
use App\Permission;
use Illuminate\Http\Request;
use DataTables;

class PermissionController extends Controller
{

    public function __construct()
    {
        $controller = explode('@', request()->route()->getAction()['controller'])[0];

        $this->middleware('allowed:' . $controller);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.user_management.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $forms = Form::get();

        return view('dashboard.user_management.permission.create', [
            'forms' => $forms,
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
            'name' => 'required|string',
            'form' => 'required|exists:forms,id',
        ]);

        Permission::create([
            'name' => $request->name,
            'form_id' => $request->form,
            'slug' => str_slug($request->name, '_'),
        ]);

        session()->flash('success', 'Permission Added!');
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
        $permission = Permission::findOrFail($id);
        $forms = Form::get();

        return view('dashboard.user_management.permission.edit', [
            'forms' => $forms,
            'permission' => $permission,
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
            'form' => 'required|exists:forms,id',
        ]);

        Permission::findOrFail($id)->update([
            'name' => $request->name,
            'form_id' => $request->form,
        ]);

        session()->flash('success', 'Permission Updated!');
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
        $permission = Permission::findOrFail($id);

        if($permission->isAssignedToRole())
        {
            session()->flash('warning', 'Unable to remove permission, already assigned to a role!');
            return redirect()->back();
        }

        $permission->delete();

        session()->flash('success', 'Permission Removed!');
        return redirect()->back();
    }

    public function getAllPermissions()
    {
        $permissions = Permission::get();

        return DataTables::of($permissions)->make();
    }
}
