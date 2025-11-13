<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // صلاحيات المستخدمين
        $userPermissions = [
            'view-user', 'create-user', 'edit-user', 'delete-user', 'show-user','force-delete-user','restore-user',
        ];

        $rolePermissions = [
            'view-role', 'create-role', 'edit-role', 'delete-role', 'show-role',
        ];

        $settingPermissions = [
            'view-setting', 'create-setting', 'edit-setting', 'delete-setting', 'show-setting',
        ];

        $profilePermissions = [ 
            'edit-profile', 'show-profile', 'change-password',
        ];
        $warehousesPermissions = [
            'view-all-warehouses'
        ];
        // إنشاء الصلاحيات
        foreach ($userPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'User']);
        }
        foreach ($rolePermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Role']);
        }
        foreach ($settingPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Setting']);
        }
        foreach ($profilePermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Profile']);
        }
        foreach ($warehousesPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Other Warehouses']);
        }
        // إنشاء الأدوار
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole      = Role::firstOrCreate(['name' => 'admin']);

        // إنشاء المستخدم Super Admin (بدون مستودع)
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'المدير العام',
                'password' => Hash::make('password'),
                'warehouse_id' => warehouse::first()->id, // لا ينتمي لأي مستودع
            ]
        );
        $superAdminUser->assignRole($superAdminRole);
        $superAdminRole->syncPermissions(Permission::all());

        $adminRole->syncPermissions(Permission::whereNotIn('name', ['view-all-warehouses'])->get());
        // إنشاء مدراء لكل مستودع
        $warehouses = Warehouse::all();

        foreach ($warehouses as $index => $warehouse) {
            $user = User::firstOrCreate(
                ['email' => 'admin'.$index.'@stl.com'],
                [
                    'name' => 'مدير '.$warehouse->name,
                    'password' => Hash::make('password'),
                    'warehouse_id' => $warehouse->id,
                ]
            );

            $user->assignRole($adminRole);
        }
    }
}
