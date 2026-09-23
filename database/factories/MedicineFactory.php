<?php

namespace Database\Factories;

use App\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Medicine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_sinhala' => $this->faker->name,
            'name_english' => $this->faker->unique()->safeEmail,
            'qty' => $this->faker->numerify('###'),
        ];
    }
}