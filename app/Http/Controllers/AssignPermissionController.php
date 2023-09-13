<?php

namespace App\Http\Controllers;

use App\Permission;
use App\UserRole;
use Illuminate\Http\Request;
use DataTables;

class AssignPermissionController extends Controller
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
        return view('dashboard.user_management.assign_permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        $roles = UserRole::get();

        return view('dashboard.user_management.assign_permission.create', [
            'roles' => $roles,
            'permissions' => $permissions,
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
            'role_id' => 'required|exists:user_roles,id',
            'permission_id' => 'required',
        ]);

        $permission = Permission::find($request->permission_id);

        $userRole = UserRole::find($request->role_id);

        $userRole->permissions()->detach();
        $userRole->permissions()->attach($permission);

        session()->flash('success', 'Permission Assigned!');
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

    public function getRolePermissions()
    {
        $roles = UserRole::with('permissions');

        return DataTables::eloquent($roles)->toJson();
    }

    /**
     * Get the Role Permissions by Role ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRolePermissionsById($id)
    {
        $role = UserRole::with('permissions')->find($id);

        return response()->json($role);
    }
}
