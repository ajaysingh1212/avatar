<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{

    public function index()
    {

        $permissions = Permission::latest()->get();

        return view('admin.permissions.index',compact('permissions'));

    }


    public function create()
    {

        return view('admin.permissions.create');

    }


    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:permissions'
        ]);

        Permission::create([
            'name'=>$request->name,
            'slug'=>$request->slug
        ]);

        return redirect()->route('admin.permissions.index')
        ->with('success','Permission Created');

    }


    public function edit($id)
    {

        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit',compact('permission'));

    }


    public function update(Request $request,$id)
    {

        $permission = Permission::findOrFail($id);

        $request->validate([
            'name'=>'required',
            'slug'=>"required|unique:permissions,slug,$id"
        ]);

        $permission->update([
            'name'=>$request->name,
            'slug'=>$request->slug
        ]);

        return redirect()->route('admin.permissions.index')
        ->with('success','Permission Updated');

    }


    public function destroy($id)
    {

        $permission = Permission::findOrFail($id);

        $permission->delete();

        return back()->with('success','Permission Deleted');

    }

}
