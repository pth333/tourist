<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
{
    public function formChangePassword(){
        return view('auth.change-password');
    }
    public function updatePassword(Request $request){

        $currentUser = Auth::user();
        // dd($currentUser);
        // dd($request->current_password);
        if(Hash::check($request->current_password, $currentUser->password)){
            $currentUser->update([
                'password' => bcrypt($request->new_password),
            ]);
            // dd(Auth::user());
            return redirect()->route('login.user')->with('ok', 'Đổi mật khẩu thành công');
        }else{
            return redirect()->back()->with('no', 'Mật khẩu cũ không tồn tại');
        }
    }
}
