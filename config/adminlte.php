<?php

    return [
        'title' => 'SISRel V2',
        'brand' => '<img src="'.env('APP_URL').'/images/logo.png"> <b>Sis</b>ReL',
        'menu' => [
            [
                'title' => 'Laman Utama',
                'icon' => 'fa-home',
                'url' => ''
            ],
            [
                'title' => 'Tetapan Admin',
                'icon' => 'fa-cogs',
                'submenu' => [
                    [
                        'title' => 'Pejabat Kastam Daerah',
                        'icon' => 'fa-building',
                        'url' => '/admin/offices'
                    ],
                    [
                        'title' => 'Pengurusan Pengguna',
                        'icon' => 'fa-users',
                        'url' => '/admin/users'
                    ]
                ],
                'can' => ['admin']
            ]
        ]
    ];

?>