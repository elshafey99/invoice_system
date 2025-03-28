<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:View Validity', ['only' => ['index']]);
        $this->middleware('permission:Add Validity', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit Validity', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Validity', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('roles.create', compact('permission'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|unique:roles,name',
    //         'permission' => 'required',
    //     ]);
    //     $role = Role::create(['name' => $request->input('name')]);
    //     $role->syncPermissions($request->input('permission'));
    //     return redirect()->route('roles.index')
    //         ->with('success', 'Role created successfully');
    // }
    public function store(Request $request)
    {
        // تحقق من صحة البيانات
        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ]);
        $role = Role::create(['name' => $validatedData['name']]);
        $permissions = Permission::whereIn('id', $validatedData['permission'])->pluck('name')->toArray();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.view')->with('Add', 'Role created successfully');
    }
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ]);

        // البحث عن الدور، وإذا لم يكن موجودًا، إعادة توجيه مع رسالة خطأ
        $role = Role::find($id);
        if (!$role) {
            return redirect()->route('roles.view')->with('error', 'Role not found');
        }
        $role->update(['name' => $validatedData['name']]);
        $permissions = Permission::whereIn('id', $validatedData['permission'])->pluck('name')->toArray();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.view')->with('edit', 'Role updated successfully');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.view')
            ->with('delete', 'Role deleted successfully');
    }
}
