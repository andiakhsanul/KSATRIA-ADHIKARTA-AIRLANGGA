<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class TimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            DB::table('tim')->insert([
                'nama_tim' => $faker->userName,
                'proposal_path' => $faker->optional()->filePath(),
                'pkm_id' => $faker->numberBetween(1, 10), // Sesuaikan dengan jumlah jenis PKM yang tersedia
                'created_at' => now(),
            ]);
        }
    }
}
