<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('id', '!=', 1)->with('permissions')->get();
        if ($roles) {
            return response()->json([
                'success' => true,
                'roles' => $roles

            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Roles not found'
            ]);
        }
    }

    public function roleCardData(){
        $totalUsers = User::count();
        $totalActive = User::where('status', 'Active')->count();
        $totalInActive = User::where('status', 'In-Active')->count();
        $totalRoles = Role::count();
        return response()->json([
            'totalUsers' => $totalUsers,
            'totalActive' => $totalActive,
            'totalInActive' => $totalInActive,
            'totalRoles' => $totalRoles,
        ]);
    }
    public function getModules()
    {
        $modules = Module::all();
        if ($modules){
            return response()->json([
                'success' => true,
                'data' => $modules,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Modules not found.'
            ]);
        }
    }
    public function store(RoleStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $role = Role::create(['guard_name' => 'web', 'name'=> $request->name]);
            $role->givePermissionTo($request->permissions);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully.',
                'role' => $role->load('permissions')
            ]);

        } catch (\Exceptionon $e){

            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $modules = Module::all();
        $breadcrumbs = [
            "Roles" => route("admin.roles.index"),
            "Roles Details" => '',
        ];
        return view('admin.role.edit', compact('role', 'modules', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        DB::beginTransaction();

        try {
            $role->syncPermissions($request['permissions']);
            $role->update($request->all());

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully.',
                'role' => $role->load('permissions')
            ]);

        } catch (\Exception $e){

            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.'

        ]);
    }
}
