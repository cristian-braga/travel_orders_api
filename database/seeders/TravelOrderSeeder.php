<?php

namespace Database\Seeders;

use App\Models\TravelOrder;
use Illuminate\Database\Seeder;

class TravelOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TravelOrder::factory(20)->create();
    }
}
