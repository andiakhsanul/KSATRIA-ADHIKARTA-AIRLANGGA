<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoredProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetUserCounts');
        
        DB::unprepared('
            CREATE PROCEDURE GetUserCounts()
            BEGIN
                SELECT 
                    COUNT(*) AS total_users, 
                    COUNT(CASE WHEN status = 1 THEN 1 END) AS approved_users
                FROM users;
            END
        ');
    }
}
