<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard',

            'categories',
            'categories.category_level_0.create',
            'categories.category_level_0.view',
            'categories.category_level_0.edit',
            'categories.category_level_0.delete',
            'categories.category_level_1.create',
            'categories.category_level_1.view',
            'categories.category_level_1.edit',
            'categories.category_level_1.delete',
            'categories.category_level_2.create',
            'categories.category_level_2.view',
            'categories.category_level_2.edit',
            'categories.category_level_2.delete',
            'content',
        ];
        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // Check if "admin",'superadmin' role exists
        $role_admin = Role::firstOrCreate(['name' => 'admin']);
        $role_superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        // Assign all permissions to the "admin",'superadmin' role if not already assigned
        $role_admin->syncPermissions(Permission::all());
        $role_superadmin->syncPermissions(Permission::all());
        // Assign the "admin" role to all users who have this role
        $adminUsers = User::role('admin')->get();
        // $superadminUsers = User::role('superadmin')->get();
        foreach ($adminUsers as $user1) {
            $user1->syncPermissions(Permission::all());
        }
        // foreach ($superadminUsers as $user2) {
        //     $user2->syncPermissions(Permission::all());
        // }
    }
}
