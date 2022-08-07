<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create(

            [
                'name' => 'Admin',
                'password' => Hash::make('Admin'),
                'role_id' => RoleUser::where('role', 'Admin')->first()->id
            ]
        );
    }
}
