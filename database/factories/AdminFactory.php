<?php

namespace Database\Factories;

use App\admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class adminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'main' => 'Falonchiyev F.',
            'accountant' => 'Falonchiyev F.',
            'name' => 'URGAZ CARPET',
            'address' => ' Samarqand shahri, Urgut tumani',
            'inn_number' => '204005443',
            'nds_number' => '3182200178',
        ];
    }
}
