<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hero;
class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hero::factory()->count(5)->create([
            'name' => 'Hero Name',
            'damage' => 100,
            'health' => 200,
            'armor' => 50,
        ]);
    }
}
