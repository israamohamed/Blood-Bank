<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function change_password_form()
    {
        return view('admin.changePassword');
    }

    public function change_password_submit(Request $request)
    {
        $rules = [
            'oldPassword' => 'required' ,
            'newPassword' => 'required|confirmed' 
        ];

        $this->validate($request , $rules);

        
        if (Hash::check($request->input('oldPassword') , $request->user()->password)) 
        {
            $user = $request->user();
            $user->password = Hash::make($request->input('newPassword'));
            $user->save();

            //echo "Changed !! ";
            return redirect(url(route('login')));     
        }

        else 
        {
            return redirect(url(route('login')));  
        }
    }
}
