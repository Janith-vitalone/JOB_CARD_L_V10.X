<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class UserRoleController extends Controller
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
        return view('dashboard.user_management.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.user_management.roles.create');
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

        UserRole::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_')
        ]);

        session()->flash('success', 'User Role Added!');
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
        $userRole = UserRole::findOrFail($id);
        return view('dashboard.user_management.roles.edit', ['userRole'=>$userRole]);
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

        $userRole = UserRole::findOrFail($id);
        $userRole->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_')
        ]);

        session()->flash('success', 'User Role Updated!');
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
        $userRole = UserRole::findOrFail($id);

        // Check role has assigned to users
        if($userRole->isAssignedToUser())
        {
            session()->flash('warning', 'Unable to remove User Role, Already assigned to user!');
            return redirect()->back();
        }

        $userRole->delete();

        session()->flash('success', 'User Role Removed!');
        return redirect()->back();
    }

    public function getAllRoles()
    {
        $userRoles = UserRole::all();

        return DataTables::of($userRoles)->make();
    }
}
