<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;


class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $countries = ['United States', 'Canada', 'India', 'Australia'];
        foreach ($countries as $country) {
            Country::create(['name' => $country]);
        }
    }
}
