<?php

return [

    'title' => 'Daftar',

    'heading' => 'Daftar Akun Warga',

    'actions' => [

        'login' => [
            'before' => 'atau',
            'label' => 'masuk ke akun yang sudah ada',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Alamat email',
        ],

        'name' => [
            'label' => 'Nama',
        ],

        'password' => [
            'label' => 'Kata sandi',
            'validation_attribute' => 'password',
        ],

        'password_confirmation' => [
            'label' => 'Konfirmasi kata sandi',
        ],

        'actions' => [

            'register' => [
                'label' => 'Daftar Akun Warga',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Terlalu banyak permintaan',
            'body' => 'Silakan coba lagi dalam :seconds detik.',
        ],

    ],

];
