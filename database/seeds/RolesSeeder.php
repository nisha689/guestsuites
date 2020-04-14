<?php

use Illuminate\Database\Seeder;
use \App\Classes\Models\Roles\Roles;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $items = [['role_id'   => 1,
                   'role_name' => 'Admin'],
                  ['role_id'   => 2,
                   'role_name' => 'Business'],
                  ['role_id'   => 3,
                   'role_name' => 'Customer'],
        ];
        foreach ( $items as $item ) {
            Roles::create( $item );
        }
    }
}
