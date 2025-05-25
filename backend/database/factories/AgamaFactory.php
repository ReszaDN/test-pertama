<?php

namespace Database\Factories;

use App\Models\ModelAgama;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModelAgama>
 */
class AgamaFactory extends Factory
{
    protected $model = ModelAgama::class;

    public function definition(): array
    {
        $agama =
            [
                'Islam',
                'Kristen',
                'Katholik',
                'Hindu',
                'Budha',
                'Yahudi',
                'Konghucu',
            ];
        return [
            'uuid' => $this->faker->uuid(),
            'is_active' => true,
            'nama' => $this->faker->randomElement($agama),
            'created_by' => $this->faker->uuid(),
            'updated_by' => $this->faker->uuid(),
        ];
    }
}
