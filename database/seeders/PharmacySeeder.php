<?php

namespace Database\Seeders;

use App\Models\Pharmacy;
use App\Models\Warehouse;
use App\Models\Area;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PharmacySeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-pharmacy',
            'create-pharmacy',
            'edit-pharmacy',
            'delete-pharmacy',
            'show-pharmacy',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Pharmacy']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole->givePermissionTo($permissions);
        $superAdminRole->givePermissionTo($permissions);

        $wh = Warehouse::orderBy('id')->first();
        $area = Area::orderBy('id')->first();
        $rep = User::role('Representative')->orderBy('id')->first();

        if ($wh && $area) {
            Pharmacy::firstOrCreate([
                'name' => 'صيدلية المركز',
                'warehouse_id' => $wh->id,
                'area_id' => $area->id,
                'representative_id' => $rep?->id,
            ]);
        }
    }
}
