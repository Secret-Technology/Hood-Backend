<?php

return [
    'user' => [
        'uploads' => [
            'img' => [
                'path' => 'uploads/user/img/',
                'default' => 'default/user_avatar.jpg',
                'image' => [
                    'min_resolution' => 100,
                    'store_resolution' => 150,
                    'max_file_size_kb' => 5000,
                ],
            ],
        ],
    ],
    'country' => [
        'uploads' => [
            'img' => [
                'path' => 'uploads/country/img/',
                'default' => 'default/place_holder.jpg',
                'image' => [
                    'min_resolution' => 100,
                    'store_resolution' => 150,
                    'max_file_size_kb' => 5000,
                ],
            ],
        ],
    ],
    'package' => [
        'uploads' => [
            'img' => [
                'path' => 'uploads/package/img/',
                'default' => 'default/place_holder.jpg'
            ],
        ],
    ],
    'parcel_category' => [
        'uploads' => [
            'img' => [
                'path' => 'uploads/parcel_category/img/',
                'default' => 'default/place_holder.jpg'
            ],
        ],
    ]
];
