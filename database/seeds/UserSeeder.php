<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->insert([
				[
					'first_name' => 'Imad',
					'last_name'  => 'Bazzal',
					'phone'      => '123456789',
					'email'      => 'imad.bazzal.93@gmail.com',
					'password'   => Hash::make('8734969091'),
				],
				[
					'first_name' => 'First',
					'last_name'  => 'Writer',
					'phone'      => '123456789',
					'email'      => 'writer@example.com',
					'password'   => Hash::make('secret'),
				],
				[
					'first_name' => 'First',
					'last_name'  => 'Desiger',
					'phone'      => '123456789',
					'email'      => 'designer@example.com',
					'password'   => Hash::make('secret'),
				],
				[
					'first_name' => 'First',
					'last_name'  => 'Manager',
					'phone'      => '123456789',
					'email'      => 'manager@example.com',
					'password'   => Hash::make('secret'),
				],
				[
					'first_name' => 'First',
					'last_name'  => 'Editor',
					'phone'      => '123456789',
					'email'      => 'editor@example.com',
					'password'   => Hash::make('secret'),
				],
			]

		);
	}
}
