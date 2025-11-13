<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Factory;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-product',
            'create-product',
            'edit-product',
            'delete-product',
            'show-product',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Product']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole->givePermissionTo($permissions);
        $superAdminRole->givePermissionTo($permissions);

        $factory = Factory::orderBy('id')->first();
        $warehouse = Warehouse::orderBy('id')->first();

        if ($factory && $warehouse) {
            Product::firstOrCreate([
                'name' => 'منتج تجريبي',
                'factory_id' => $factory->id,
                'warehouse_id' => $warehouse->id,
            ], [
                'unit_price' => 0,
            ]);
        }
    }
}
