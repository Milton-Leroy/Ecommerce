<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use File;

class ProfileController extends Controller
{
    public function index(){
        return view('admin.profile.index');
    }

    public function updateProfile(Request $request){

        $userId = auth()->user()->id;

       $request->validate([
        'name' => ['required', 'max:100'],
        'email' => ['required', 'email', 'unique:users,email,'.$userId],
        'image' => ['nullable', 'image', 'max:2048']
       ]);

       $user = User::findOrFail($userId);

       if($request->hasFile('image')){

            if(File::exists(public_path($user->image))){
                File::delete(public_path($user->image));
            }

            $image = $request->image;
            $imageName = rand().''.$image->getClientOriginalName();
            $image->move(public_path('uploads'),$imageName);

            $path = 'uploads/'.$imageName;

            $user->image = $path;
       }

       $user->name = $request->name;
       $user->email = $request->email;
       $user->save();

       return redirect()->back();
    }

    /* Update Password */
    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back();
    }
}
