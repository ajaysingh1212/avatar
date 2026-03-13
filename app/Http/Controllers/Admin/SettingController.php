<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingController extends Controller
{

    /**
     * Display settings
     */
    public function index()
    {
        $setting = Setting::first();

        return view('admin.settings.index', compact('setting'));
    }


    /**
     * Show create form
     * Only if setting not exists
     */
    public function create()
    {
        $setting = Setting::first();

        if ($setting) {
            return redirect()->route('admin.settings.edit', $setting->id);
        }

        return view('admin.settings.create');
    }


    /**
     * Store setting
     * Prevent duplicate creation
     */
    public function store(Request $request)
    {

        if (Setting::count() > 0) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Settings already exist. You can only update.');
        }

        $request->validate([
            'app_name' => 'required'
        ]);

        $setting = Setting::create($request->all());


        // Upload Logo
        if ($request->hasFile('app_logo')) {

            $file = $request->file('app_logo')->store('settings', 'public');

            Media::create([

                'model_type' => Setting::class,
                'model_id' => $setting->id,

                'uuid' => Str::uuid(),

                'collection_name' => 'logo',
                'name' => 'logo',

                'file_name' => basename($file),

                'mime_type' => $request->file('app_logo')->getMimeType(),

                'disk' => 'public',

                'size' => $request->file('app_logo')->getSize()

            ]);
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings Created Successfully');
    }


    /**
     * Edit settings
     */
    public function edit()
    {
        $setting = Setting::firstOrFail();

        return view('admin.settings.edit', compact('setting'));
    }


    /**
     * Update settings
     */
    public function update(Request $request)
    {

        $setting = Setting::firstOrFail();

        $setting->update($request->all());


        // Update Logo
        if ($request->hasFile('app_logo')) {

            $old = Media::where('model_type', Setting::class)
                ->where('model_id', $setting->id)
                ->where('collection_name', 'logo')
                ->first();

            if ($old) {

                Storage::disk('public')->delete('settings/' . $old->file_name);

                $old->delete();
            }


            $file = $request->file('app_logo')->store('settings', 'public');


            Media::create([

                'model_type' => Setting::class,
                'model_id' => $setting->id,

                'uuid' => Str::uuid(),

                'collection_name' => 'logo',
                'name' => 'logo',

                'file_name' => basename($file),

                'mime_type' => $request->file('app_logo')->getMimeType(),

                'disk' => 'public',

                'size' => $request->file('app_logo')->getSize()

            ]);
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings Updated Successfully');
    }

}
