<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::create([
            'name' => [
                'ar' => 'سيارة',
                'en' => 'Car',
                'en' => 'گاڑی',
            ],
            'is_active' => true,
            'is_parcel' => false,
            'km_price'  => 100
        ]);

        Package::create([
            'name' => [
                'ar' => 'دراجة',
                'en' => 'Bike',
                'en' => 'موٹر سائیکل',
            ],
            'is_active' => true,
            'is_parcel' => false,
            'km_price'  => 70
        ]);

        Package::create([
            'name' => [
                'ar' => 'بضائع',
                'en' => 'Parcel',
                'ur' => 'سامان'
            ],
            'is_active' => true,
            'is_parcel' => true,
            'km_price'  => 120
        ]);

        Package::create([
            'name' => [
                'ar' => 'سيارة فارهه',
                'en' => 'Luxury',
                'en' => 'لگژری کار',
            ],
            'is_active' => true,
            'is_parcel' => false,
            'km_price'  => 130
        ]);
    }
}
