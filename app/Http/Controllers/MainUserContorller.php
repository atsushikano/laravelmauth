<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainUserContorller extends Controller
{
    public function Logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function UserProfile(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('user.profile.view_profile', compact('user'));

    }

    public function UserProfileEdit(){
        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('user.profile.view_profile_edit', compact('editData'));
    }

    public function UserProfileStore(Request $request){
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;

        if($request->file('profile_photo_path')) {
            $file = $request->file('profile_photo_path');
            @unlink(public_path('upload/user_images/'.$data->profile_photo_path));
            $filename = date('YMdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['profile_photo_path'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('user.profile')->with($notification);


    }
}
