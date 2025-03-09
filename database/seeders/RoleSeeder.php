<?php

namespace Database\Seeders;

use App\Models\RoleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleModel::create([
            'nama_role' => 'operator'
        ]);
        RoleModel::create([
            'nama_role' => 'reviewer'
        ]);
        RoleModel::create([
            'nama_role' => 'tim'
        ]);
    }
}
