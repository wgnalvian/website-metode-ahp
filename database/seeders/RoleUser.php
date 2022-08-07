<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\RoleUser::create(
           
            [
                'role' => 'Admin'
            ]
        );
        
        \App\Models\RoleUser::create(
           
            [
                'role' => 'User'
            ]
        );
        
    }
}
