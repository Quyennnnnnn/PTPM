<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoaiNguyenLieu>
 */
class LoaiHangFactory extends Factory
{
    protected $model = \App\Models\LoaiNguyenLieu::class;

    public function definition(): array
    {
        return [
            'Ten_Loai_Nguyen_Lieu' => $this->faker->text(100),  // Updated field name
            'Mo_Ta' => $this->faker->text(255),                // Field for description
        ];
    }
}
