<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTestingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $this->post('/register', ['username' => 'Alvian', 'password' => '1234'])->assertSessionHasErrors('password');
        $this->post('/register', ['username' => '', 'password' => '1234'])->assertSessionHasErrors('username');
        dump($this->post('/register', ['username' => 'Alvian', 'password' => '1234', 'password_confirmation' => '1234']));

        $this->assertDatabaseHas('users',['name' => 'Alvian','password' => Hash::make('1234')]);

    }
}
