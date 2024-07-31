<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Trait\DeleteModalTrait;

class ManagerUserController extends Controller
{
    use DeleteModalTrait;
    private $user;
    private $role;
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }
    public function index()
    {
        $users = $this->user->whereHas('roles')->paginate(5);
        $roles = $this->role->all();
        return view('admin.user.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->roles()->attach($request->role_id);
        return redirect()->back()->with('ok', 'Thêm người dùng thành công');
    }

    public function edit($id)
    {
        $users = $this->user->find($id);
        $roles = $this->role->all();
        $roleUsers = $users->roles;
        // dd($roleUsers);
        return response()->json([
            'code' => 200,
            'user' => $users,
            'roles' => $roles,
            'roleUsers' => $roleUsers

        ], 200);
    }

    public function update(Request $request)
    {
        $userId = $request->input('userId');
        if (empty($userId)) {
            return view('errors.403');
        } else {
            $user = $this->user->find($userId);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $user = $this->user->find($userId);
            // dd($request->role_id);
            $user->roles()->sync($request->role_id);
            return redirect()->route('user.index')->with('ok', 'Đã sửa thành công !');
        }
    }

    public function destroy($id)
    {
        if (empty($id)) {
            return view('errors.403');
        }
        return $this->deleteModalTrait($id, $this->user);
    }
}
