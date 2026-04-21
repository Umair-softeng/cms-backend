<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Branches;
use App\Models\Complaints;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        if(Auth::user()->hasRole('Super Admin')){
            $users = User::with('roles')->get();
            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'Users retrieved successfully.'

            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'No Permission',
            ]);
        }

    }

    public function cardData(): JsonResponse
    {
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

    public function store(UserStoreRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Create user (safe mass assignment)
            $user = User::create($request->validated());

            // Assign role if provided
            if ($request->filled('roleID')) {
                $role = Role::findOrFail($request->roleID);
                $user->assignRole($role);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'user' => $user->fresh('roles'),
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
            ], 500);
        }
    }

    public function show(User $user): JsonResponse
    {
        if ($user){
            return response()->json([
                'user' => $user->load(['roles', 'branch']),
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user->update($request->all());
            if (isset($request->roleID)) {
                $role = Role::find($request->roleID);
                $user->syncRoles($role);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $user->load(['roles', 'branch']),
                'message' => 'User updated successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            throw $e;
        }
    }

    public function destroy(User $user): JsonResponse
    {
        if ((int) $user->system_reserve === 1) {
            return response()->json([
                'success' => false,
                'message' => 'This user is system reserved and cannot be deleted',
            ], 403);
        }

        DB::beginTransaction();

        try {
            $user->roles()->detach();

            // Optional: detach permissions if you use direct permissions on users
            if (method_exists($user, 'permissions')) {
                $user->permissions()->detach();
            }

            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user',
                // 'error' => $e->getMessage(), // enable in dev
            ], 500);
        }
    }

    public function status(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->system_reserve == 1) {
            return response()->json([
                'success' => false,
                'message' => 'This user is system reserved and cannot be updated',
            ], 403);
        }

        $user->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'user' => $user->fresh(),
        ]);
    }

    public function loggedUser(): JsonResponse
    {
        $user = Auth::user()->load('roles');

        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

}
