<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Geofence;
use Illuminate\Http\Request;

class GeofenceController extends Controller
{

    public function index()
    {
        $geofences = Geofence::latest()->get();

        return view('admin.geofences.index',compact('geofences'));
    }


    public function create()
    {
        return view('admin.geofences.create');
    }


    public function store(Request $request)
    {

        Geofence::create($request->all());

        return redirect()
        ->route('admin.geofences.index')
        ->with('success','Geofence Created');
    }


    public function edit($id)
    {
        $geofence = Geofence::findOrFail($id);

        return view('admin.geofences.edit',compact('geofence'));
    }


    public function update(Request $request,$id)
    {

        $geofence = Geofence::findOrFail($id);

        $geofence->update($request->all());

        return redirect()
        ->route('admin.geofences.index')
        ->with('success','Geofence Updated');
    }


    public function destroy($id)
    {
        Geofence::findOrFail($id)->delete();

        return back();
    }

}
