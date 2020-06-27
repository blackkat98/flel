<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Enums\DefaultUserRole;

class RoleController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.roles.list', [
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
     * @param  App\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $name = $request->get('name');

        $selected_permissions_id = [];
        $permissions = [];

        for ($i = 1; $i <= Permission::max('id'); $i++) {
            if ($request->get('permission-' . $i)) {
                $selected_permissions_id[] = $i;
            }
        }

        if (count($selected_permissions_id) > 0) {
            $permissions = Permission::whereIn('id', $selected_permissions_id)->get();
        }

        $role = Role::create([
            'name' => $name
        ]);

        if ($role->id) {
            if ($permissions) {
                $role->syncPermissions($permissions);
            }

            return redirect()->back()->with('success', $role->name . ' ' . __('has been created'));
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
     * @param  App\Http\Requests\RoleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = Role::findById($id);
        $role->name = $request->get('name');

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

        $existing_permissions = $role->permissions;

        if ($role->save()) {
            if ($existing_permissions) {
                foreach ($existing_permissions as $e_perm) {
                    $role->revokePermissionTo($e_perm);
                }
            }

            if ($selected_permissions) {
                $role->syncPermissions($selected_permissions);
            }

            return redirect()->back()->with('success', $role->name . ' ' . __('has been updated'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findById($id);

        if (count($role->users) > 0) {
            return redirect()->back()->with('error', __('Action Failed'));
        }

        if (in_array($role->name, array_flip(DefaultUserRole::toArray()))) {
            return redirect()->back()->with('error', __('Action Failed'));
        }

        $existing_permissions = $role->permissions;

        if ($existing_permissions) {
            foreach ($existing_permissions as $e_perm) {
                $role->revokePermissionTo($e_perm);
            }
        }

        if ($role->delete()) {
            return redirect()->back()->with('success', $role->name . ' ' . __('has been updated'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
