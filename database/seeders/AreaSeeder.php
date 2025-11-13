<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Warehouse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-area',
            'create-area',
            'edit-area',
            'delete-area',
            'show-area',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Area']);
        }

        $whAleppo = Warehouse::where('name', 'مستودع حلب الشمالي')->first();
        $whStp = Warehouse::where('name', 'مستودع STP-Bazar')->first();
        $whIstanbul = Warehouse::where('name', 'مستودع اسطنبول الأوروبي')->first();

        $areasData = [];
        if ($whAleppo) {
            $areasData[] = ['name' => 'منطقة حلب - A', 'warehouse_id' => $whAleppo->id];
            $areasData[] = ['name' => 'منطقة حلب - B', 'warehouse_id' => $whAleppo->id];
        }
        if ($whStp) {
            $areasData[] = ['name' => 'منطقة STP - A', 'warehouse_id' => $whStp->id];
        }
        if ($whIstanbul) {
            $areasData[] = ['name' => 'منطقة اسطنبول - A', 'warehouse_id' => $whIstanbul->id];
            $areasData[] = ['name' => 'منطقة اسطنبول - B', 'warehouse_id' => $whIstanbul->id];
        }

        foreach ($areasData as $area) {
            Area::firstOrCreate(['name' => $area['name']], $area);
        }
    }
}
