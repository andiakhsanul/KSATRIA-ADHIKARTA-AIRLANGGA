<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 50; $i++) {
            DB::table('users')->insert([
                'nama_lengkap' => $faker->name,
                'nim' => "4342310" . str_pad($i, 2, '0', STR_PAD_LEFT),
                'nip' => null,
                'email' => "user$i@example.com",
                'tim_id' => $i % 20 + 1, // Distribute users across 20 teams
                'role_id' => 3, // Normal user role
                'password' => Hash::make('12345678'),
                'status' => 2,
                'created_at' => now(),
            ]);
        }
    }
}
