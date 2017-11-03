<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 20)->create();
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'imad.bazzal.93@gmail.com',
            'password' => Hash::make('8734969091'),
        ]);
    }
}
