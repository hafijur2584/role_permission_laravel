<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create role
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        $roleEditor = Role::create(['name' => 'editor']);
        $roleUser = Role::create(['name' => 'user']);


        //create permission
        $permissions = [
            //dashboard
            'dashboard.view',

            //blog permission
            'blog.create',
            'blog.view',
            'blog.edit',
            'blog.delete',
            'blog.approve',

            //admin permission
            'admin.create',
            'admin.view',
            'admin.edit',
            'admin.delete',
            'admin.approve',

            //role permission
            'role.create',
            'role.view',
            'role.edit',
            'role.delete',
            'role.approve',

            //profile permissions
            'profile.view',
            'profile.edit'

        ];

        //create and Assign permissions

        for ($i = 0; $i < count($permissions); $i++) {
            //create permission
            $permission = Permission::create(['name' => $permissions[$i]]);
            $roleSuperAdmin->givePermissionTo($permission);
            $permission->assignRole($roleSuperAdmin);
        }
    }
}
