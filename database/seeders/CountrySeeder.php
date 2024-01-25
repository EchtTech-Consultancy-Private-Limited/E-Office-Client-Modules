<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();
        $countries = [
            ['id' => 1, 'name' => 'India', 'abbreviation' => 'IN', 'dial_code' => 91, 'flag' => 'india'],
        ];
        DB::table('countries')->insert($countries);
    }
}
