<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MainAdminController extends Controller
{
    public function AdminProfile(){
        $adminData = Admin::find(1);
        return view('admin.profile.view_profile',compact('adminData'));
    }

    public function AdminProfileEdit(){
        // $id = Auth::admin()->id;
        $editData = Admin::find(1);
        return view('admin.profile.view_profile_edit', compact('editData'));
    }

    public function AdminProfileStore(Request $request){
        $data = Admin::find(1);
        $data->name = $request->name;
        $data->email = $request->email;

        if($request->file('profile_photo_path')) {
            $file = $request->file('profile_photo_path');
            @unlink(public_path('upload/admin_images/'.$data->profile_photo_path));
            $filename = date('YMdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['profile_photo_path'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.profile')->with($notification);
    }
    public function AdminPasswordView(){
        return view('admin.password.edit_password');
    }

    public function AdminPasswordUpdate(Request $request){
        $validataData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword =  Admin::find(1)->password;
        if(Hash::check($request->oldpassword,$hashedPassword)){
            $adminUser = Admin::find(1);
            $adminUser->password = Hash::make($request->password);
            $adminUser->save();
            Auth::logout();
            return redirect()->route('admin.logout');
        }else{
            return redirect()->back();
        }
    }

}
