<?php

use Illuminate\Database\Seeder;

class BugsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bugs')->truncate();

        $faker = Faker\Factory::create();

        foreach (range(1, 50) as $item) {
            DB::table('bugs')->insert([
                'happening' => $faker->realText(200),
                'supposed' => $faker->realText(200),
                'reproduce' => $faker->realText(200),
                'contact' => $faker->email,
                'ip' => $faker->ipv4,
                'created_at' => $faker->dateTime,
                'client_os' => $faker->linuxPlatformToken,
                'game_version' => $faker->buildingNumber
            ]);
        }
    }
}
