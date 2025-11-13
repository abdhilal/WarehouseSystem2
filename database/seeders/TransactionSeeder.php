<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Warehouse;
use App\Models\Factory;
use App\Models\Pharmacy;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-transaction',
            'create-transaction',
            'edit-transaction',
            'delete-transaction',
            'show-transaction',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Transaction']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole->givePermissionTo($permissions);
        $superAdminRole->givePermissionTo($permissions);

        $warehouse = Warehouse::orderBy('id')->first();
        $factory = Factory::orderBy('id')->first();
        $pharmacy = Pharmacy::orderBy('id')->first();
        $representative = User::role('Representative')->orderBy('id')->first();
        $product = Product::orderBy('id')->first();

        if ($warehouse && $factory && $pharmacy && $representative && $product) {
            Transaction::firstOrCreate([
                'warehouse_id' => $warehouse->id,
                'factory_id' => $factory->id,
                'pharmacy_id' => $pharmacy->id,
                'representative_id' => $representative->id,
                'product_id' => $product->id,
                'type' => 'Wholesale Sale',
            ], [
                'quantity' => 0,
                'value' => 0,
                'gift_value' => 0,
            ]);
        }
    }
}
