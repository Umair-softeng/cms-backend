<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->get();
        if ($users){
            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'Users retrieved successfully.'

            ]);
        }else{

            return response()->json([
                'success' => false,
                'message' => 'Users not found.'
            ]);
        }
    }


    public function store(UserCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => "Active",
                'departmentID' => $request->departmentID,
                'mobileNo' => $request->mobileNo,
            ]);
            if ($request->roleID) {
                $role = Role::findOrFail($request->roleID);
                $user->assignRole($role);
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('toast_message', 'User Created Successfully..!!');
        } catch (\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $departments = Departments::all();
        $roles = Role::all();

        $newComplaints = Complaint::where('userID', $user->id)->where('status', 'New')->sum('complaintID');
        $progressComplaints = Complaint::where('userID', $user->id)->where('status', 'In-Progress')->sum('complaintID');
        $resolvedComplaints = Complaint::where('userID', $user->id)->where('status', 'Resolved')->sum('complaintID');
        $droppedComplaints = Complaint::where('userID', $user->id)->where('status', 'Dropped')->sum('complaintID');
        $breadcrumbs = [
            "Users" => route("admin.users.index"),
            "Users Details" => '',
        ];
        return view('admin.user.show', compact('user', 'departments', 'roles', 'newComplaints', 'progressComplaints', 'resolvedComplaints', 'droppedComplaints', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $departments = Departments::all();
        $roles = Role::all();
        $breadcrumbs = [
            "Users" => route("admin.users.index"),
            "Users Edit" => '',
        ];
        return view('admin.user.edit', compact('user', 'departments', 'roles', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $user->update([
                "name" => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => "Active",
                'departmentID' => $request->departmentID,
                'mobileNo' => $request->mobileNo,
            ]);

            if ($user->system_reserve) {
                return redirect()->route('admin.users.index')->with('toast_message' , 'This user cannot be update, It is system reserved..!!');
            }

            if (isset($request->roleID)) {
                $role = Role::find($request->roleID);
                $user->syncRoles($role);
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('toast_message', 'User Updated Successfully');

        } catch (Exception $e) {

            DB::rollback();

            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('toast_message', 'User Deleted Successfully..!!');

    }

    public function status(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['status' => $request->status]);
            return json_encode(["resp" => $user]);

        } catch (\Exception $e) {

            throw $e;
        }
    }
}
