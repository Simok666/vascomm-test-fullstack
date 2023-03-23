<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@testing.com',
               'password'=> bcrypt('123456'),
            ],
        ];

        foreach ($user as $key => $value) {

            $addUser = User::create($value);
            $addUser->attachRole('admin'); 
        
             event(new Registered($addUser));
        }
    }
}
