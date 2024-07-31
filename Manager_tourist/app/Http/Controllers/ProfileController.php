<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function showProfile()
    {
        return view('admin.personal.index');
    }
    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ], [
            'email.required' => 'Vui lòng nhập vào trường',
            'email.email' => 'Vui lòng nhập email',
            'email.exists' => 'Email không tồn tại'
        ]);
        User::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('dashboard')->with('ok', 'Cập nhật thông tin cá nhân thành công');
    }
}
