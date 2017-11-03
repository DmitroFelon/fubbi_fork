<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'admin',
            'display_name' => 'Service administrator',
            'description' => 'Admin, has all possible permissions',
        ]);

        DB::table('roles')->insert([
            'name' => 'client',
            'display_name' => 'Client',
            'description' => 'Client, the most important person here',
        ]);

        DB::table('roles')->insert([
            'name' => 'account_manager',
            'display_name' => 'Account Manager',
            'description' => 'Account Manager, handles non-trivial actions',
        ]);

        DB::table('roles')->insert([
            'name' => 'writer',
            'display_name' => 'Writer',
            'description' => 'Writer, creates text content',
        ]);

        DB::table('roles')->insert([
            'name' => 'editor',
            'display_name' => 'Editor',
            'description' => 'Editor, edits created content',
        ]);

        DB::table('roles')->insert([
            'name' => 'designer',
            'display_name' => 'Designer',
            'description' => 'Designer, creates appearance',
        ]);
    }
}
