<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create(
            [
                'name' => [
                    'ar' => 'المملكة العربية السعودية',
                    'en' => 'kingdom of saudi arabia'
                ],
                'phone_code' => '966',
                'code' => 'ksa',
                'currency_name' => [
                    'ar' => 'ريال سعودى',
                    'en' => 'Saudi Riyal',
                ],
                'currency_symbol' => 'SAR',
                'is_active' => 1
            ]
        );
    }
}
