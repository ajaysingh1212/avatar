<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::latest()->get();

        return view('admin.roles.index', compact('roles'));
    }


    public function create()
    {
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:roles'
        ]);

        $role = Role::create([
            'name'=>$request->name,
            'slug'=>$request->slug
        ]);

        if($request->permissions){
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.roles.index')
        ->with('success','Role Created');
    }


    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::all();

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view(
            'admin.roles.edit',
            compact('role','permissions','rolePermissions')
        );
    }


    public function update(Request $request,$id)
    {

        $role = Role::findOrFail($id);

        $request->validate([
            'name'=>'required',
            'slug'=>"required|unique:roles,slug,$id"
        ]);

        $role->update([
            'name'=>$request->name,
            'slug'=>$request->slug
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index')
        ->with('success','Role Updated');
    }


    public function destroy($id)
    {

        $role = Role::findOrFail($id);

        $role->delete();

        return back()->with('success','Role Deleted');
    }

}
