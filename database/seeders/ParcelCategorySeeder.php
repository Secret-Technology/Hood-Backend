<?php

namespace Database\Seeders;

use App\Models\ParcelCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParcelCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ParcelCategory::create([
            'name' => [
                'ar' => 'صندوق',
                'en' => 'Parcel Box'
            ],
            'is_active' => true
        ]);

        ParcelCategory::create([
            'name' => [
                'ar' => 'ملفات',
                'en' => 'Documents'
            ],
            'is_active' => true
        ]);

        ParcelCategory::create([
            'name' => [
                'ar' => 'قابل للكسر',
                'en' => 'Fragile'
            ],
            'is_active' => true
        ]);

        ParcelCategory::create([
            'name' => [
                'ar' => 'هدية',
                'en' => 'gift'
            ],
            'is_active' => true
        ]);
    }
}
