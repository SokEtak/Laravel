<?php

namespace Database\Seeders;

use App\Models\ProductInventory;
use Illuminate\Database\Seeder;

class ProductInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductInventory::factory()->count(10)->create();
    }
}
