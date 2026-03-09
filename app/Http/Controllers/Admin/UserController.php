<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;

class UserController extends Controller
{

    public function index()
    {

        $users = User::latest()->get();

        return view('admin.users.index',compact('users'));

    }


    public function create()
    {

        $roles = Role::all();

        return view('admin.users.create',compact('roles'));

    }


    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);

        $user = User::create([

            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)

        ]);

        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.index')
        ->with('success','User Created');

    }


    public function edit($id)
    {

        $user = User::findOrFail($id);

        $roles = Role::all();

        $userRoles = $user->roles->pluck('id')->toArray();

        return view(
            'admin.users.edit',
            compact('user','roles','userRoles')
        );

    }


    public function update(Request $request,$id)
    {

        $user = User::findOrFail($id);

        $request->validate([
            'name'=>'required',
            'email'=>"required|email|unique:users,email,$id"
        ]);

        $data = [
            'name'=>$request->name,
            'email'=>$request->email
        ];

        if($request->password){
            $data['password']=Hash::make($request->password);
        }

        $user->update($data);

        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.index')
        ->with('success','User Updated');

    }
public function show($id)
{

$user = User::with('roles')->findOrFail($id);

return view('admin.users.show',compact('user'));

}

    public function destroy($id)
    {

        $user = User::findOrFail($id);

        $user->delete();

        return back()->with('success','User Deleted');

    }

}
