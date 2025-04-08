<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HangHoa>
 */
class HangHoaFactory extends Factory
{
    protected $model = \App\Models\HangHoa::class;

    public function definition(): array
    {
        return [
            'ma_hang_hoa' => $this->faker->unique()->text(50),
            'ten_hang_hoa' => $this->faker->name,
            'mo_ta' => $this->faker->text(255),
            'id_loai_hang' => $this->faker->numberBetween($min = 1, $max = 10),
            'don_vi_tinh' => $this->faker->name,
            'barcode' => $this->faker->ean8,
            'img' => 'hanghoa.jpg',
        ];
    }
}
