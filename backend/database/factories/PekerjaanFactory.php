<?php

namespace Database\Factories;

use App\Models\ModelPekerjaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModelPekerjaan>
 */
class PekerjaanFactory extends Factory
{
    protected $model = ModelPekerjaan::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'is_active' => $this->faker->boolean(),
            'nama' => $this->faker->jobTitle(),
            'created_by' => $this->faker->name(),
            'updated_by' => $this->faker->name(),
        ];
    }
}
