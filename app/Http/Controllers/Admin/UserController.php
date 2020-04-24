<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UserController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.users.list', [
            'users' => $users,
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));

        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image'));
            $user->image = config('customize.storage_dir') . $path;
        } else {
            $user->image = config('customize.default_avatar');
        }

        $selected_roles_id = [];

        for ($i = 1; $i <= Role::max('id'); $i++) {
            if ($request->get('role-' . $i)) {
                $selected_roles_id[] = $i;
            }
        }

        if (count($selected_roles_id) > 0) {
            $selected_roles = Role::whereIn('id', $selected_roles_id)->get();
        }

        if ($user->save()) {
            if ($selected_roles) {
                foreach ($selected_roles as $role) {
                    $user->assignRole($role);
                }
            }

            return redirect()->back()->with('success', $user->name . ' ' . __('has been created'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update the Roles of a specific User.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $existing_roles = $user->roles;

        $selected_roles_id = [];
        $selected_roles = [];

        for ($i = 1; $i <= Role::max('id'); $i++) {
            if ($request->get('role-' . $i)) {
                $selected_roles_id[] = $i;
            }
        }

        if (count($selected_roles_id) > 0) {
            $selected_roles = Role::whereIn('id', $selected_roles_id)->get();
        }

        if ($existing_roles) {
            foreach ($existing_roles as $e_role) {
                $user->removeRole($e_role);
            }
        }

        if ($selected_roles) {
            foreach ($selected_roles as $role) {
                $user->assignRole($role);
            }
        }

        return redirect()->back();
    }

    /**
     * Update the Direct Permissions of a specific User.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermissions(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $existing_permissions = $user->permissions;

        $selected_permissions_id = [];
        $selected_permissions = [];

        for ($i = 1; $i <= Permission::max('id'); $i++) {
            if ($request->get('permission-' . $i)) {
                $selected_permissions_id[] = $i;
            }
        }

        if (count($selected_permissions_id) > 0) {
            $selected_permissions = Permission::whereIn('id', $selected_permissions_id)->get();
        }

        if ($existing_permissions) {
            foreach ($existing_permissions as $e_permission) {
                $user->revokePermissionTo($e_permission);
            }
        }

        if ($selected_permissions) {
            foreach ($selected_permissions as $permission) {
                $user->givePermissionTo($permission);
            }
        }

        return redirect()->back();
    }
}
