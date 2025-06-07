<?php

namespace Database\Seeders;

use App\Constants\UserDetailConstant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\RTArea;
use App\Models\RWSetting;
use Carbon\Carbon;

class RWSeeder extends Seeder
{
    public function run(): void
    {
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

        // Create Ketua RW user
        $rwUser = User::create([
            'name'          => 'Andre Subianto',
            'email'         => 'rw09@rwdigital.test',
            'password'      => Hash::make('password'),
            'role'          => 'ketua_rw',
            'nik'           => '3172' . str_pad((string) rand(1000000000, 9999999999), 12, '0', STR_PAD_LEFT),
            'phone_number'  => '08' . rand(1111111111, 9999999999),
            'verified_at' => Carbon::now(),
        ]);

        // Update Ketua RW user detail
        $rwUser->detail()->firstOrCreate([
            'house_no'          => 'RW-01',
            'gender'            => UserDetailConstant::GENDER_MALE,
            'date_of_birth'     => '1973-01-23',
            'place_of_birth'    => fake()->city(),
        ]);

        // Create RTs and assign Ketua RT + 10 Warga
        for ($i = 1; $i <= 12; $i++) {
            $gender = fake()->randomElement(UserDetailConstant::GENDER_ENUMS);

            $rtNumber = str_pad($i, 3, '0', STR_PAD_LEFT);

            // Create RTArea
            $rtArea = RTArea::firstOrCreate([
                'name'          => "RT $rtNumber",
                'address'       => "Jl. RT $rtNumber, RW 09, Srengseng Sawah",
                'latitude'      => -6.34500000 + ($i * 0.001),
                'longitude'     => 106.82000000 + ($i * 0.001),
                'google_maps'   => "https://maps.google.com/?q=" . (-6.34500000 + ($i * 0.001)) . "," . (106.82000000 + ($i * 0.001)),
            ]);

            // Create Ketua RT user
            $rtUser = User::firstOrCreate([
                'name'          => fake()->name(str($gender)->lower()),
                'email'         => "rt$rtNumber@rwdigital.test",
                'password'      => Hash::make('password'),
                'role'          => 'ketua_rt',
                'nik'           => '3172' . str_pad((string) rand(1000000000, 9999999999), 12, '0', STR_PAD_LEFT),
                'phone_number'  => '08' . rand(1111111111, 9999999999),
                'verified_at' => Carbon::now(),
            ]);

            // Update Ketua RT user detail
            $rtUser->detail()->firstOrCreate([
                'rt_area_id'        => $rtArea->id,
                'house_no'          => 'RT-' . $rtNumber,
                'gender'            => $gender,
                'date_of_birth'     => '1973-01-23',
                'place_of_birth'    => fake()->city(),
            ]);

            // Create 10 warga users for each RT
            for ($j = 1; $j <= 10; $j++) {
                $wargaNumber = str_pad($j, 3, '0', STR_PAD_LEFT);

                $gender = fake()->randomElement(UserDetailConstant::GENDER_ENUMS);

                $wargaUser = User::firstOrCreate([
                    'name'          => fake()->name(str($gender)->lower()),
                    'email'         => "warga$j.rt$rtNumber@rwdigital.test",
                    'password'      => Hash::make('password'),
                    'role'          => 'warga',
                    'nik'           => '3172' . str_pad((string) rand(1000000000, 9999999999), 12, '0', STR_PAD_LEFT),
                    'verified_at' => Carbon::now(),
                    'phone_number'  => '08' . rand(1111111111, 9999999999),
                ]);

                $wargaUser->detail()->firstOrCreate([
                    'rt_area_id'        => $rtArea->id,
                    'gender'            => $gender,
                    'house_no'          => 'W-' . $rtNumber . ' ' . $wargaNumber,
                    'date_of_birth'     => '1973-01-23',
                    'place_of_birth'    => fake()->city(),
                ]);
            }
        }
    }
}
