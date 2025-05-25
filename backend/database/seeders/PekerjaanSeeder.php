<?php

namespace Database\Seeders;

use App\Models\ModelPekerjaan;
use Illuminate\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelPekerjaan::factory()->count(10)->create();
    }
}
