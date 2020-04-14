<?php

use Illuminate\Database\Seeder;
use \App\Classes\Models\State\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [	['state_id'=>1, 'state_name'=>'Alabama',],
                      ['state_id'=>2, 'state_name'=> 'Alaska',],
                      ['state_id'=>3, 'state_name'=>'American Samoa',],
                      ['state_id'=>4, 'state_name'=>'Arizona',],
                      ['state_id'=>5, 'state_name'=>'Arkansas',],
                      ['state_id'=>6, 'state_name'=>'Armed Forces Africa',],
                      ['state_id'=>7, 'state_name'=>'Armed Forces Americas',],
                      ['state_id'=>8, 'state_name'=>'Armed Forces Canada',],
                      ['state_id'=>9, 'state_name'=>'Armed Forces Europe',],
                      ['state_id'=>10, 'state_name'=>'Armed Forces Middle East',],
                      ['state_id'=>11, 'state_name'=>'Armed Forces Pacific',],
                      ['state_id'=>12, 'state_name'=>'California',],
                      ['state_id'=>13, 'state_name'=>'Colorado',],
                      ['state_id'=>14, 'state_name'=>'Connecticut',],
                      ['state_id'=>15, 'state_name'=>'Delaware',],
                      ['state_id'=>16, 'state_name'=>'District of Columbia',],
                      ['state_id'=>17,  'state_name'=>'Federated States Of Micronesia',],
                      ['state_id'=>18,  'state_name'=>'Florida',],
                      ['state_id'=>19,  'state_name'=>'Georgia',],
                      ['state_id'=>20,  'state_name'=>'Guam',],
                      ['state_id'=>21,  'state_name'=>'Hawaii',],
                      ['state_id'=>22,  'state_name'=>'Idaho',],
                      ['state_id'=>23,  'state_name'=>'Illinois',],
                      ['state_id'=>24,  'state_name'=>'Indiana',],
                      ['state_id'=>25,  'state_name'=>'Iowa',],
                      ['state_id'=>26,  'state_name'=>'Kansas',],
                      ['state_id'=>27,  'state_name'=>'Kentucky',],
                      ['state_id'=>28,  'state_name'=>'Louisiana',],
                      ['state_id'=>29,  'state_name'=>'Maine',],
                      ['state_id'=>30,  'state_name'=>'Marshall Islands',],
                      ['state_id'=>31,  'state_name'=>'Maryland',],
                      ['state_id'=>32,  'state_name'=>'Massachusetts',],
                      ['state_id'=>33,  'state_name'=>'Michigan',],
                      ['state_id'=>34,  'state_name'=>'Minnesota',],
                      ['state_id'=>35,  'state_name'=>'Mississippi',],
                      ['state_id'=>36, 'state_name'=>'Missouri',],
                      ['state_id'=>37, 'state_name'=> 'Montana',],
                      ['state_id'=>38, 'state_name'=> 'Nebraska',],
                      ['state_id'=>39, 'state_name'=> 'Nevada',],
                      ['state_id'=>40, 'state_name'=> 'New Hampshire',],
                      ['state_id'=>41, 'state_name'=> 'New Jersey',],
                      ['state_id'=>42, 'state_name'=> 'New Mexico',],
                      ['state_id'=>43, 'state_name'=> 'New York',],
                      ['state_id'=>44, 'state_name'=> 'North Carolina',],
                      ['state_id'=>45, 'state_name'=> 'North Dakota',],
                      ['state_id'=>46, 'state_name'=> 'Northern Mariana Islands',],
                      ['state_id'=>47, 'state_name'=> 'Ohio',],
                      ['state_id'=>48,  'state_name'=>'Oklahoma',],
                      ['state_id'=>49,  'state_name'=>'Oregon',],
                      ['state_id'=>50, 'state_name'=> 'Palau',],
                      ['state_id'=>51, 'state_name'=> 'Pennsylvania',],
                      ['state_id'=>52, 'state_name'=> 'Puerto Rico',],
                      ['state_id'=>53,  'state_name'=>'Rhode Island',],
                      ['state_id'=>54,  'state_name'=>'South Carolina',],
                      ['state_id'=>55,  'state_name'=>'South Dakota',],
                      ['state_id'=>56,  'state_name'=>'Tennessee',],
                      ['state_id'=>57,  'state_name'=>'Texas',],
                      ['state_id'=>58, 'state_name'=>'Utah',],
                      ['state_id'=>59,  'state_name'=>'Vermont',],
                      ['state_id'=>60,  'state_name'=>'Virgin Islands',],
                      ['state_id'=>61,  'state_name'=>'Virginia',],
                      ['state_id'=>62,  'state_name'=>'Washington',],
                      ['state_id'=>63,  'state_name'=>'West Virginia',],
                      ['state_id'=>64,  'state_name'=>'Wisconsin',],
                      ['state_id'=>65,  'state_name'=>'Wyoming',],
        ];

        foreach ($items as $item) {
            State::create($item);
        }
    }
}
