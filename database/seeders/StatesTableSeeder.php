<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $states = [
            'United States' => ['Alabama', 'Alaska', 'Arizona', 'Arkansas'],
            'Canada' => ['Alberta', 'British Columbia', 'Manitoba', 'New Brunswick'],
            'India' => ['Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'West Bengal'],
            'Australia' => ['New South Wales', 'Queensland', 'South Australia', 'Tasmania']
        ];

        foreach ($states as $country => $stateList) {
            $countryModel = Country::where('name', $country)->first();
            foreach ($stateList as $state) {
                State::create(['country_id' => $countryModel->id, 'name' => $state]);
            }
        }
    }
}
