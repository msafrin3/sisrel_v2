<?php

    return [
        'title' => 'SISRel V2',
        'brand' => '<img src="'.env('APP_URL').'/images/logo.png"> <b>Sis</b>ReL',
        'menu' => [
            [
                'title' => 'Home',
                'icon' => 'fa-home',
                'url' => ''
            ],
            [
                'title' => 'Dashboard',
                'icon' => 'fa-dashboard',
                'submenu' => [
                    [
                        'title' => 'Menu 1',
                        'icon' => 'fa-circle-o',
                        'url' => '/menu1'
                    ],
                    [
                        'title' => 'Menu 2',
                        'icon' => 'fa-circle-o',
                        'url' => '/menu2'
                    ]
                ],
                'can' => ['admin']
            ],
            [
                'title' => 'Admin Setting',
                'icon' => 'fa-cogs',
                'submenu' => [
                    [
                        'title' => 'User Management',
                        'icon' => 'fa-users',
                        'url' => '/admin/users'
                    ]
                ],
                'can' => ['admin']
            ]
        ]
    ];

?>