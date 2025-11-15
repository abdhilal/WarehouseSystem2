<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Representative;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RepresentativeSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-representative',
            'create-representative',
            'edit-representative',
            'delete-representative',
            'show-representative',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Representative']);
        }

        $role = Role::firstOrCreate(['name' => 'Representative']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole->givePermissionTo($permissions);
        $superAdminRole->givePermissionTo($permissions);

        $whAleppo = Warehouse::where('name', 'مستودع حلب الشمالي')->first();
        $whStp = Warehouse::where('name', 'مستودع STP-Bazar')->first();
        $whIstanbul = Warehouse::where('name', 'مستودع اسطنبول الأوروبي')->first();




        if ($whIstanbul) {
            Representative::create([
                'name' => 'مندوب اسطنبول',
                'type' => 'sales',
                'warehouse_id' => $whIstanbul->id,
            ]);
        }
    }
}
