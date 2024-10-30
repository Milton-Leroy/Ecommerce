<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;

class UserProfileController extends Controller
{
    public function index(){
        return view("frontend.dashboard.profile");
    }

    public function updateProfile(Request $request){
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'image' => ['nullable', 'image', 'max:2048']
        ]);

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

        toastr()->success('Profile Updated Sucessfully');

        return redirect()->back();
    }
}
