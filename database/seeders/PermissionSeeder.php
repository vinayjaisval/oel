<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    //  php artisan db:seed PermissionSeeder
    public function run()
{
    try {
        $permissionList = config('permissionlist.permissions');

        // Create Role
        $role = Role::firstOrCreate(['name' => 'Administrator']);

        // Create Permissions
        foreach ($permissionList as $permissions) {
            foreach ($permissions as $subPermission) {
                if (!empty($subPermission)) {
                    Permission::firstOrCreate(['name' => $subPermission]);
                }
            }
        }

        // Assign all permissions to role
        $role->syncPermissions(Permission::pluck('id')->toArray());

        // Create Admin User
        $user = User::firstOrCreate(
            ['email' => 'admin@com'], // unique field
            [
                'name' => 'RIC',
                'status' => 1,
                'password' => Hash::make('12345678'),
                'admin_type' => 'Administrator'
            ]
        );

        // Assign Role (avoid duplicate attach)
        if (!$user->hasRole('Administrator')) {
            $user->assignRole($role);
        }

    } catch (\Exception $e) {
        \Log::error('Seeder Error: ' . $e->getMessage());
    }
}
}

