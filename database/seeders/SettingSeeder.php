<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'about_ar',
            'value'=>' <p> عن التطبيق </p>',
            'is_active' => true
        ]);
        Setting::create([
            'key' => 'about_en',
            'value'=>'<p>About APP </p>',
            'is_active' => true
        ]);

        Setting::create([
            'key' => 'about_urd',
            'value'=>' <p> عن التطبيق </p>',
            'is_active' => true
        ]);
        Setting::create([
            'key' => 'terms_ar',
            'value'=>' <p> عن التطبيق </p>',
            'is_active' => true
        ]);
        Setting::create([
            'key' => 'terms_en',
            'value'=>'<p>About APP </p>',
            'is_active' => true
        ]);

        Setting::create([
            'key' => 'terms_urd',
            'value'=>' <p> عن التطبيق </p>',
            'is_active' => true
        ]);
        Setting::create([
            'key' => 'email',
            'value'=>'email@email.com',
            'is_active' => true
        ]);
        Setting::create([
            'key' => 'phone',
            'value'=>'+9665131231231',
            'is_active' => true
        ]);

    }
}
