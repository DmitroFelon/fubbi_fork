<?php

use Illuminate\Database\Seeder;

class KeywordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();

        $rows = [];

        for ($i = 0; $i<=100; $i++){
            $rows[] = [
                "text" => $faker->unique()->word
            ];
        }

        DB::table('keywords')->insert($rows);
    }
}
