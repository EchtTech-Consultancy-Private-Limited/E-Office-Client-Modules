<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::truncate();
        $states = [
            ['country_id' => 1, 'name' => 'Andaman and Nicobar Islands', 'abbreviation' => 'AN'],
            ['country_id' => 1, 'name' => 'Andhra Pradesh', 'abbreviation' => 'AP'],
            ['country_id' => 1, 'name' => 'Arunachal Pradesh', 'abbreviation' => 'AR'],
            ['country_id' => 1, 'name' => 'Assam', 'abbreviation' => 'AS'],
            ['country_id' => 1, 'name' => 'Bihar', 'abbreviation' => 'BR'],
            ['country_id' => 1, 'name' => 'Chandigarh', 'abbreviation' => 'CH'],
            ['country_id' => 1, 'name' => 'Chhattisgarh', 'abbreviation' => 'CG'],
            ['country_id' => 1, 'name' => 'Dadra and Nagar Haveli', 'abbreviation' => 'DH'],
            ['country_id' => 1, 'name' => 'Daman and Diu', 'abbreviation' => 'DD'],
            ['country_id' => 1, 'name' => 'Delhi', 'abbreviation' => 'DL'],
            ['country_id' => 1, 'name' => 'Goa', 'abbreviation' => 'GA'],
            ['country_id' => 1, 'name' => 'Gujarat', 'abbreviation' => 'GJ'],
            ['country_id' => 1, 'name' => 'Haryana', 'abbreviation' => 'HR'],
            ['country_id' => 1, 'name' => 'Himachal Pradesh', 'abbreviation' => 'HP'],
            ['country_id' => 1, 'name' => 'Jammu and Kashmir', 'abbreviation' => 'JK'],
            ['country_id' => 1, 'name' => 'Jharkhand', 'abbreviation' => 'JH'],
            ['country_id' => 1, 'name' => 'Karnataka', 'abbreviation' => 'KA'],
            ['country_id' => 1, 'name' => 'Kenmore', 'abbreviation' => 'KN'],
            ['country_id' => 1, 'name' => 'Kerala', 'abbreviation' => 'KL'],
            ['country_id' => 1, 'name' => 'Lakshadweep', 'abbreviation' => 'LD'],
            ['country_id' => 1, 'name' => 'Madhya Pradesh', 'abbreviation' => 'MP'],
            ['country_id' => 1, 'name' => 'Maharashtra', 'abbreviation' => 'MH'],
            ['country_id' => 1, 'name' => 'Manipur', 'abbreviation' => 'MN'],
            ['country_id' => 1, 'name' => 'Meghalaya', 'abbreviation' => 'ML'],
            ['country_id' => 1, 'name' => 'Mizoram', 'abbreviation' => 'MZ'],
            ['country_id' => 1, 'name' => 'Nagaland', 'abbreviation' => 'NL'],
            ['country_id' => 1, 'name' => 'Narora', 'abbreviation' => 'NR'],
            ['country_id' => 1, 'name' => 'Natwar', 'abbreviation' => 'NT'],
            ['country_id' => 1, 'name' => 'Odisha', 'abbreviation' => 'OR'],
            ['country_id' => 1, 'name' => 'Paschim Medinipur', 'abbreviation' => 'PM'],
            ['country_id' => 1, 'name' => 'Pondicherry', 'abbreviation' => 'PY'],
            ['country_id' => 1, 'name' => 'Punjab', 'abbreviation' => 'PB'],
            ['country_id' => 1, 'name' => 'Rajasthan', 'abbreviation' => 'RJ'],
            ['country_id' => 1, 'name' => 'Sikkim', 'abbreviation' => 'SK'],
            ['country_id' => 1, 'name' => 'Tamil Nadu', 'abbreviation' => 'TN'],
            ['country_id' => 1, 'name' => 'Telangana', 'abbreviation' => 'TS'],
            ['country_id' => 1, 'name' => 'Tripura', 'abbreviation' => 'TR'],
            ['country_id' => 1, 'name' => 'Uttar Pradesh', 'abbreviation' => 'UP'],
            ['country_id' => 1, 'name' => 'Uttarakhand', 'abbreviation' => 'UK'],
            ['country_id' => 1, 'name' => 'Vaishali', 'abbreviation' => 'VS'],
            ['country_id' => 1, 'name' => 'West Bengal', 'abbreviation' => 'WB'],
        ];
        DB::table('states')->insert($states);
    }
}
