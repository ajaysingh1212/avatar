<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {

    $user = auth()->user();

    $request->validate([
    'name'=>'required',
    'email'=>'required|email'
    ]);

    $user->update([
    'name'=>$request->name,
    'email'=>$request->email
    ]);

    if($request->password){
    $user->update([
    'password'=>Hash::make($request->password)
    ]);
    }


    /* Profile Photo Upload */

    if($request->hasFile('profile_photo')){

    $user->media()
    ->where('collection_name','profile')
    ->delete();

    $file = $request->file('profile_photo');

    $path = $file->store('profile','public');

    Media::create([

    'model_type'=>User::class,
    'model_id'=>$user->id,
    'uuid'=>Str::uuid(),
    'collection_name'=>'profile',
    'name'=>$file->getClientOriginalName(),
    'file_name'=>$path,
    'mime_type'=>$file->getMimeType(),
    'disk'=>'public',
    'size'=>$file->getSize(),

    ]);

    }


    /* Cover Photo Upload */

    if($request->hasFile('cover_photo')){

    $user->media()
    ->where('collection_name','cover')
    ->delete();

    $file = $request->file('cover_photo');

    $path = $file->store('cover','public');

    Media::create([

    'model_type'=>User::class,
    'model_id'=>$user->id,
    'uuid'=>Str::uuid(),
    'collection_name'=>'cover',
    'name'=>$file->getClientOriginalName(),
    'file_name'=>$path,
    'mime_type'=>$file->getMimeType(),
    'disk'=>'public',
    'size'=>$file->getSize(),

    ]);

    }

    return back()->with('success','Profile Updated Successfully');

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
