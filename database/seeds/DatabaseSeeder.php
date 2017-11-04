<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(ProjectsWorkersSeeder::class);
        $this->call(TeamsTableSeed::class);
        $this->call(TeamsUsersTableSeeder::class);
        $this->call(RolesUsersTableSeeder::class);
    }
}
