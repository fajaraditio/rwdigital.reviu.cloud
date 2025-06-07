<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\RTArea;
use App\Models\RWSetting;

class RWSeeder extends Seeder
{
    public function run(): void
    {
        // Create RW user
        User::create([
            'name'          => 'Ketua RW 09',
            'email'         => 'rw09@rwdigital.test',
            'password'      => Hash::make('password'),
            'role'          => 'ketua_rw',
            'nik'           => '3172' . str_pad((string) rand(1000000000, 9999999999), 12, '0', STR_PAD_LEFT),
            'phone_number'  => '08' . rand(1111111111, 9999999999),
        ]);

        // Create RWSetting
        RWSetting::create([
            'name'          => 'RW 09',
            'address'       => 'Jl. RW 09, Srengseng Sawah',
            'sub_district'  => 'Srengseng Sawah',
            'district'      => 'Jagakarsa',
            'city'          => 'Jakarta Selatan',
            'province'      => 'DKI Jakarta',
            'latitude'      => -6.32100000,
            'longitude'     => 106.83300000,
            'google_maps'   => 'https://maps.google.com/?q=-6.34567890,106.82345678',
        ]);

        // Create RTs and assign Ketua RT + 10 Warga
        for ($i = 1; $i <= 12; $i++) {
            $rtNumber = str_pad($i, 3, '0', STR_PAD_LEFT);

            // Create RT User
            $rtUser = User::firstOrCreate([
                'name'          => "Ketua RT $rtNumber",
                'email'         => "rt$rtNumber@rwdigital.test",
                'password'      => Hash::make('password'),
                'role'          => 'ketua_rt',
                'nik'           => '3172' . str_pad((string) rand(1000000000, 9999999999), 12, '0', STR_PAD_LEFT),
                'phone_number'  => '08' . rand(1111111111, 9999999999),
            ]);

            // Create RTArea
            $rtArea = RTArea::firstOrCreate([
                'ketua_rt_id'   => $rtUser->id,
                'name'          => "RT $rtNumber",
                'address'       => "Jl. RT $rtNumber, RW 09, Srengseng Sawah",
                'latitude'      => -6.34500000 + ($i * 0.001),
                'longitude'     => 106.82000000 + ($i * 0.001),
                'google_maps'   => "https://maps.google.com/?q=" . (-6.34500000 + ($i * 0.001)) . "," . (106.82000000 + ($i * 0.001)),
            ]);

            // Update Ketua RT

            $rtUser->update(['rt_area_id' => $rtArea->id]);

            // Create 10 warga users for each RT
            for ($j = 1; $j <= 10; $j++) {
                User::firstOrCreate([
                    'rt_area_id'    => $rtArea->id,
                    'name'          => "Warga $j RT $rtNumber",
                    'email'         => "warga$j.rt$rtNumber@rwdigital.test",
                    'password'      => Hash::make('password'),
                    'role'          => 'warga',
                    'nik'           => '3172' . str_pad((string) rand(1000000000, 9999999999), 12, '0', STR_PAD_LEFT),
                    'phone_number'  => '08' . rand(1111111111, 9999999999),
                ]);
            }
        }
    }
}
