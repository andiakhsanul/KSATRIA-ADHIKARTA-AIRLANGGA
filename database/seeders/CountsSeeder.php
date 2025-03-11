<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCounts');

        DB::unprepared('
            CREATE PROCEDURE GetCounts()
            BEGIN
                SELECT 
                    (SELECT COUNT(*) FROM tim) AS total_teams,
                    (SELECT COUNT(*) FROM proposal) AS total_proposals,
                    (SELECT COUNT(*) FROM revisi) AS total_revisions;
            END
        ');
    }
}
