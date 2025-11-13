<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warehouse;
use App\Models\Area;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
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

        $areaAleppoA = Area::where('name', 'منطقة حلب - A')->first();
        $areaStpA = Area::where('name', 'منطقة STP - A')->first();
        $areaIstanbulA = Area::where('name', 'منطقة اسطنبول - A')->first();

        $representativesData = [];
        if ($whAleppo && $areaAleppoA) {
            $representativesData[] = [
                'name' => 'مندوب حلب',
                'email' => 'rep.aleppo@stl.com',
                'password' => Hash::make('password'),
                'warehouse_id' => $whAleppo->id,
                'area_id' => $areaAleppoA->id,
            ];
        }
        if ($whStp && $areaStpA) {
            $representativesData[] = [
                'name' => 'مندوب STP',
                'email' => 'rep.stp@stl.com',
                'password' => Hash::make('password'),
                'warehouse_id' => $whStp->id,
                'area_id' => $areaStpA->id,
            ];
        }
        if ($whIstanbul && $areaIstanbulA) {
            $representativesData[] = [
                'name' => 'مندوب اسطنبول',
                'email' => 'rep.ist@stl.com',
                'password' => Hash::make('password'),
                'warehouse_id' => $whIstanbul->id,
                'area_id' => $areaIstanbulA->id,
            ];
        }

        foreach ($representativesData as $data) {
            $user = User::firstOrCreate(['email' => $data['email']], $data);
            $user->assignRole($role);
        }
    }
}