<?php

use Illuminate\Database\Seeder;

class TeamsUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [];
        for ($i = 0; $i < 21; $i++) {
            $rows[] = [
                'team_id' => rand(1, 2),
                'user_id' => rand(1, 21)
            ];
        }

        DB::table('team_user')->insert($rows);
    }
}
