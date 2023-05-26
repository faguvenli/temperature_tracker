<?php

namespace App\Http\Actions;

use App\Models\PermissionGroup;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAction
{
    public function store($data) {

        $role = Role::create(['name' => $data['name']]);
        $role->syncPermissions($data['permissions']);
        session()->flash('success', 'kaydedildi');
        return redirect()->route('roles.index');
    }

    public function update($role, $data) {

        $role->update(['name' => $data['name']]);

        $role->syncPermissions($data['permissions']);

        session()->flash('success', 'güncellendi');
        return redirect()->route('roles.edit', $role);
    }

    public function getPermissions() {
        $permission_sections = PermissionGroup::query()->orderBy('sort_order')->get();

        $permission_groups = [];

        foreach($permission_sections as $permission_section) {

            $permissions = Permission::query()->select('name', 'id')->where('permission_group_id', $permission_section->id)->orderBy('name')->get();

            foreach($permissions as $permission) {

                $group_name = explode(' - ', $permission->name);

                $permission_groups[$permission_section->name][trim($group_name[0])][$permission->id] = trim($group_name[1]);
            }
        }
        return $permission_groups;
    }
}
