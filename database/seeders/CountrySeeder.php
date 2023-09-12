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
        // Get all from the JSON file
        $JSON_countries = Country::allJSON();
        foreach ($JSON_countries as $country) {
            Country::firstOrCreate([
                'capital'             => ((isset($country['capital'])) ? $country['capital'] : null),
                'citizenship'         => ((isset($country['citizenship'])) ? $country['citizenship'] : null),
                'country_code'        => ((isset($country['country_code'])) ? $country['country_code'] : null),
                'currency'            => ((isset($country['currency'])) ? $country['currency'] : null),
                'currency_code'       => ((isset($country['currency_code'])) ? $country['currency_code'] : null),
                'currency_sub_unit'   => ((isset($country['currency_sub_unit'])) ? $country['currency_sub_unit'] : null),
                'full_name'           => ((isset($country['full_name'])) ? $country['full_name'] : null),
                'iso_3166_2'          => ((isset($country['iso_3166_2'])) ? $country['iso_3166_2'] : null),
                'iso_3166_3'          => ((isset($country['iso_3166_3'])) ? $country['iso_3166_3'] : null),
                'name'                => ((isset($country['name'])) ? $country['name'] : null),
                'region_code'         => ((isset($country['region_code'])) ? $country['region_code'] : null),
                'sub_region_code'     => ((isset($country['sub_region_code'])) ? $country['sub_region_code'] : null),
                'eea'                 => ((isset($country['eea'])) ? $country['eea'] : false),
                'phone_code'           => ((isset($country['phone_code'])) ? $country['phone_code'] : null),
                'currency_symbol'     => ((isset($country['currency_symbol'])) ? $country['currency_symbol'] : null),
                'currency_decimals'   => ((isset($country['currency_decimals'])) ? $country['currency_decimals'] : null),
                'flag'                => ((isset($country['flag'])) ? $country['flag'] : null),
                'minLength'           => ((isset($country['minLength'])) ? $country['minLength'] : 0),
                'maxLength'           => ((isset($country['maxLength'])) ? $country['maxLength'] : 0),
            ]);
        }
    }
}
