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
                'en' => 'Car'
            ],
            'is_active' => true,
            'is_parcel' => false,
            'km_price'  => 100
        ]);

        Package::create([
            'name' => [
                'ar' => 'دراجة',
                'en' => 'Bike'
            ],
            'is_active' => true,
            'is_parcel' => false,
            'km_price'  => 70
        ]);

        Package::create([
            'name' => [
                'ar' => 'بضائع',
                'en' => 'Parcel'
            ],
            'is_active' => true,
            'is_parcel' => true,
            'km_price'  => 120
        ]);

        Package::create([
            'name' => [
                'ar' => 'سيارة فارهه',
                'en' => 'Luxury'
            ],
            'is_active' => true,
            'is_parcel' => false,
            'km_price'  => 130
        ]);
    }
}
