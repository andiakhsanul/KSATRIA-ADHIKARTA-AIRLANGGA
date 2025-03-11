<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PKMSeeder::class,
            RoleSeeder::class,
            StoredProcedureSeeder::class,
            CountsSeeder::class,
            // TimSeeder::class,
            // UserSeeder::class,
        ]);

        User::create([
            'nama_lengkap' => 'operator@adhikarta.com',
            'email' => 'operator@adhikarta.com',
            'password' => 'unair-adhikarta',
            'nim' => '1234567890',
            'status' => 1, // accepted
            'role_id' => 1 // operator
        ]);

        // User::create([
        //     'nama_lengkap' => 'Muhammad Alif Adiawan',
        //     'email' => 'alifadiawan2005@gmail.com',
        //     'password' => '1234567890',
        //     'nim' => '000000000',
        //     'status' => 2, // waiting
        //     'role_id' => 3 // tim
        // ]);

        // User::create([
        //     'nama_lengkap' => 'Pak Arman',
        //     'email' => 'arman@gmail.com',
        //     'password' => '1234567890',
        //     'nip' => '00217279182',
        //     'role_id' => 2, // reviewer
        //     'status' => 1  // accepted
        // ]);

        // User::create([
        //     'nama_lengkap' => 'Bu Tessa',
        //     'email' => 'tessa@gmail.com',
        //     'password' => '1234567890',
        //     'nip' => '0878281729',
        //     'role_id' => 2, // reviewer
        //     'status' => 1  // accepted
        // ]);
    }
}
