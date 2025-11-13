<?php

namespace Database\Seeders;

use App\Models\Factory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-factory',
            'create-factory',
            'edit-factory',
            'delete-factory',
            'show-factory',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Factory']);
        }

        $factoriesData = [
            ['name' => 'مصنع الشمال'],
            ['name' => 'مصنع STP'],
            ['name' => 'مصنع اسطنبول الأوروبي'],
        ];

        foreach ($factoriesData as $factory) {
            Factory::firstOrCreate(['name' => $factory['name']], $factory);
        }
    }
}
