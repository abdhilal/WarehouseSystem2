<?php

return [
    [
        'title' => 'general',
        'items' => [
            ['label' => 'dashboard', 'icon' => 'Home-dashboard', 'url' => '/'],
            [
                'label' => 'users',
                'icon' => 'Profile',
                'children' => [

                    ['label' => 'users.index', 'icon' => 'Users', 'route' => 'users.index'],
                    ['label' => 'permissions', 'icon' => 'Shield', 'route' => 'users.permissions.manage'],
                    ['label' => 'users.deleted', 'icon' => 'Delete', 'color' => 'red',  '#'],

                ]
            ],
            ['label' => 'items', 'icon' => 'Bag', 'children' => [
                ['label' => 'Warehouses', 'icon' => 'Archive', 'route' => 'warehouses.index'],
                ['label' => 'Representatives', 'icon' => 'User', 'route' => 'representatives.index'],

                ['label' => 'Areas', 'icon' => 'Map', 'route' => 'areas.index'],
                ['label' => 'Factories', 'icon' => 'Layers', 'route' => 'factories.index'],
                ['label' => 'Products', 'icon' => 'Package', 'route' => 'products.index'],
                ['label' => 'Files', 'icon' => 'Paper', 'route' => 'files.index'],
            ]],
        ],
    ],
    [
        'title' => 'management',
        'items' => [
            [
                'label' => 'content',
                'icon' => 'Document',
                'children' => [
                    ['label' => 'categories', 'url' => '#'],
                    ['label' => 'collections', 'url' => '#'],
                ],
            ],
        ],
    ],
];
