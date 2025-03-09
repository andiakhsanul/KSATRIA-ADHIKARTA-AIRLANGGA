<?php

namespace Database\Seeders;

use App\Models\JenisPKMModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PKMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pkmTypes = [
            'PKM-RE',
            'PKM-RSH',
            'PKM-K',
            'PKM-PM',
            'PKM-PI',
            'PKM-KI',
            'PKM-KC',
            'PKM-GFT',
            'PKM-VGK',
            'PKM-AI'
        ];

        foreach ($pkmTypes as $type) {
            JenisPKMModel::create(['nama_pkm' => $type]);
        }
    }
}
