<?php

return [

    // ============================
    //       GENERAL SECTION
    // ============================
    [
        'title' => 'general',
        'items' => [
            [
                'label' => 'dashboard',
                'icon'  => 'Home',
                'url'   => '/',
            ],
            [
                'label' => 'users',
                'icon'  => 'UserGroup',
                'permissions' => ['view-role', 'view-user', 'view-customer'],
                'children' => [
                    [
                        'label' => 'users.index',
                        'icon'  => 'Users',
                        'route' => 'users.index'
                    ],
                    [
                        'label' => 'permissions',
                        'icon'  => 'Shield',
                        'route' => 'users.permissions.manage'
                    ],
                    [
                        'label' => 'Warehouses',
                        'icon'  => 'Archive',
                        'route' => 'warehouses.index',
                        'permissions' => ['view-user']

                    ],

                ]
            ],
        ],
    ],

    // ============================
    //     REPRESENTATIVES
    // ============================
    [
        'title' => 'Representatives',
        'icon'  => '<i class="iconly-User3 icli"></i>',
        'items' => [
            [
                'label' => 'Representatives',
                'icon'  => '<i class="iconly-Arrow-Left-3 icli"></i>',
                'route' => 'representatives.index'
            ],
            [
                'label' => 'Representatives Medical',
                'icon'  => '<i class="iconly-Arrow-Left-3 icli"></i>',
                'route' => 'representativesMedical.index'
            ],
        ]
    ],

    // ============================
    //          DATA SECTION
    // ============================
    [
        'title' => 'Data',
        'icon'  => '<i class="iconly-Paper-Negative icli"></i>',
        'items' => [
            [
                'label' => 'Areas',
                'icon'  => '<i class="iconly-Location icli"></i>',
                'route' => 'areas.index'
            ],
            [
                'label' => 'Pharmacies',
                'icon'  => '<i class="iconly-Buy icli"></i>',
                'route' => 'pharmacies.index'
            ],
            [
                'label' => 'Transactions',
                'icon'  => '<i class="iconly-Swap icli"></i>',
                'route' => 'transactions.index'
            ],
        ],
    ],

    // ============================
    //     ITEMS SECTION
    // ============================
    [
        'icon'  => 'Bag',
        'items' => [
            [
                'label' => 'items',
                'icon'  => '<i class="iconly-More-Circle icli"></i>',
                'children' => [

                    [
                        'label' => 'Factories',
                        'icon'  => 'Layers',
                        'route' => 'factories.index'
                    ],
                    [
                        'label' => 'Products',
                        'icon'  => 'Package',
                        'route' => 'products.index'
                    ],
                    [
                        'label' => 'Files',
                        'icon'  => 'Paperclip',
                        'route' => 'files.index'
                    ],

                ]
            ]
        ]
    ],

];
