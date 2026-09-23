<?php

namespace Database\Factories;

use App\Attendance;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::pluck('id', 'id')->random(),
            'start' => $this->faker->date('2019-m-d'),
            'end' => Carbon::now(),
        ];
    }
}