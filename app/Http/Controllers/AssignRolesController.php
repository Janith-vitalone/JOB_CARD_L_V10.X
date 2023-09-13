<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserHasRole;
use DataTables;

class AssignRolesController extends Controller
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
        return view('dashboard.user_management.assign_role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userRoles =  UserRole::all();
        $users = User::all();
        return view('dashboard.user_management.assign_role.create', ['userRoles' => $userRoles, 'users' => $users]);
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
            'name' => 'required',
            'role' => 'required'
        ]);

        $userId = $request->name;
        $hasPivot = User::whereHas('userRoles',function($q) use($userId){
                    $q->where('user_id',$userId);

        })
        ->get();

        if(count($hasPivot) > 0)
        {

            session()->flash('warning', 'User Already Assigned!');
            return redirect()->back();
        }
        else
        {

            UserHasRole::create([
                'user_id' => $request->name,
                'user_role_id' => $request->role
            ]);

            session()->flash('success', 'User Assigned Successfully!');
            return redirect()->back();
        }

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
        $userRoles = UserRole::all();
        $users = User::all();

        $userHasRole = User::where('id', $id)->get();

        return view('dashboard.user_management.assign_role.edit')->with(
            [
                'userRoles' => $userRoles ,
                'users' => $users ,
                'userHasRole' => $userHasRole
            ]
        );


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
            'role' => 'required'
        ]);

        $userHasRole = UserHasRole::where('user_id')->get();
        $userHasRole->update([
            'user_role_id' => $request->role
        ]);


        session()->flash('success', 'User Role Updated Successfully!');
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

        UserHasRole::where('user_id',$id)->delete();

        session()->flash('success', 'User Role Removed from User!');
        return redirect()->back();
    }

    public function getAllAssignedRole()
    {
        $users = User::with('userRoles');
        return DataTables::eloquent($users)->toJson();
    }
}
