<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Trait\DeleteModalTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    use DeleteModalTrait;
    private $role;
    private $permission;
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }
    public function index()
    {
        $roles = $this->role->latest()->paginate(5);
        return view('admin.role.index', compact('roles'));
    }
    public function create()
    {
        $permissionParent = $this->permission->where('parent_id', 0)->get();
        // dd($permissionParent);
        return view('admin.role.add', compact('permissionParent'));
    }
    public function store(Request $request)
    {
        $role = $this->role->create([
            'name' => $request->name,
            'display_name' => $request->display_name
        ]);
        $role->permissions()->attach($request->permission_id);
        // dd($role);
        return redirect()->route('role.index')->with('ok', 'Bạn đã thêm vai trò thành công');
    }
    public function edit($id)
    {
        $role = $this->role->find($id);
        $permissionParent = $this->permission->where('parent_id', 0)->get();
        $permissionChecked = $role->permissions;
        return view('admin.role.edit', compact('role', 'permissionParent', 'permissionChecked'));
    }
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->role->find($id)->update([
                'name' => $request->name,
                'display_name' => $request->display_name
            ]);
            $role = $this->role->find($id);
            $role->permissions()->sync($request->permission_id);
            // dd($role);
            DB::commit();
            return redirect()->route('role.index')->with('Bạn đã sửa vai trò thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line : ' . $exception->getLine());
        }
    }
    public function destroy($id)
    {
        if (empty($id)) {
            return view('errors.403');
        }
        return $this->deleteModalTrait($id, $this->role);
    }
}
