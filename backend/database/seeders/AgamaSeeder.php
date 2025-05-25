<?php

namespace Database\Seeders;

use App\Models\ModelAgama;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelAgama::factory()->count(10)->create();
    }
}
