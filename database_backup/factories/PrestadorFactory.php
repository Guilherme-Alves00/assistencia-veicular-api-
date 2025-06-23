<?php

namespace Database\Factories;

use App\Models\Prestador;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrestadorFactory extends Factory
{
    protected $model = Prestador::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'logradouro' => $this->faker->streetName,
            'bairro' => $this->faker->streetSuffix,
            'numero' => $this->faker->buildingNumber,
            'cidade' => $this->faker->city,
            'UF' => $this->faker->stateAbbr,
            'latitude' => $this->faker->latitude(-33, -10),
            'longitude' => $this->faker->longitude(-70, -35),
            'situacao' => $this->faker->randomElement(['ativo', 'inativo']),
        ];
    }
}
