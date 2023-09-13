<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

//    public function __construct()
//    {
//        $controller = explode('@', request()->route()->getAction()['controller'])[0];
//
//        $this->middleware('allowed:' . $controller)->only(['index', 'create', 'edit', 'store', 'destroy', 'show']);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.user_management.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.user_management.user.create');
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required',
            'dob' => 'required|date',
            'contact_no' => 'required',
            'password' => 'required|confirmed',
            'designation' => 'required|exists:designations,id',
            'avatar' => 'nullable|image|max:3000',
        ]);

        $avatar_url = $request->gender == 'M' ? 'default.png' : 'defaultf.png';

        if($request->hasFile('avatar'))
        {
            $avatar = $request->file('avatar');
            $directory = md5(uniqid());
            $avatar_url = '/' . $directory . '/avatar.png';

            Storage::disk('avatars')->putFileAs($directory, $avatar, 'avatar.png');
        }

        User::create([
            'name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'contact_no' => $request->contact_no,
            'password' => Hash::make($request->password),
            'designation_id' => $request->designation,
            'avatar' => $avatar_url,
        ]);

        session()->flash('success', 'User Created!');
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
        $user = User::findOrFail($id);

        return view('dashboard.user_management.user.edit', [
            'user' => $user,
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required',
            'dob' => 'required|date',
            'contact_no' => 'required',
            'avatar' => 'nullable|image|max:3000',
        ]);

        $avatar_url = $request->old_avatar;

        if($request->hasFile('avatar'))
        {
            $avatar = $request->file('avatar');
            $directory = md5(uniqid());
            $avatar_url = '/' . $directory . '/avatar.png';

            Storage::disk('avatars')->putFileAs($directory, $avatar, 'avatar.png');
        }

        $data = [
            'name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'contact_no' => $request->contact_no,
            'avatar' => $avatar_url,
        ];

        if($request->user()->userRoles[0]->slug == 'super_admin')
        {
            $request->validate([
                'designation' => 'required|exists:designations,id',
            ]);

            $data = [
                'name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'contact_no' => $request->contact_no,
                'avatar' => $avatar_url,
                'designation_id' => $request->designation,
            ];
        }

        User::findOrFail($id)->update($data);

        session()->flash('success', 'User Details Updated!');
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

    public function getAllUsers()
    {
        $users = User::with('designation', 'userRoles')->get();

        return DataTables::of($users)->make();
    }

    /**
     * Change the specific user password.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed',
            'old_password' => 'required'
        ]);

        $user = User::findOrFail($id);

        if(Hash::check($request->password, $user->password))
        {
            // Password match, update new password
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            session()->flash('success', 'Password Changed!');
            return redirect()->back();
        }

        // Password not matched, return error
        session()->flash('error', 'Invalid old password!');
        return redirect()->back();
    }

    public function profile($id, Request $request)
    {
        if($request->user()->id != $id)
        {
            return response('Unauthorized', 401);
        }

        $user = User::findOrFail($id);

        return view('dashboard.user_management.user.edit', [
            'user' => $user,
        ]);
    }
}
