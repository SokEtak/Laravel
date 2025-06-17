<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ninjas;
class NinjasSeeder extends Seeder
{
    public function run(): void
    {
        Ninjas::factory()->count(10)->create();
    }
}
