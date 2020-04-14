<?php
use Illuminate\Database\Seeder;
use \App\Classes\Models\City\City;
class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
 	{
		$items = [	['city_id' => 1,'state_id'=>1, 'city_name'=>'Abbeville',],
					['city_id' => 2,'state_id'=>1, 'city_name'=> 'Adamsville',],
					['city_id' => 3,'state_id'=>1, 'city_name'=>'Addison',],
				];

        foreach ($items as $item) {
            City::create($item);
        }
    }
}
