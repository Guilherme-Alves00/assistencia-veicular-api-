<?php

namespace Database\Factories;

use App\Models\Servico;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicoFactory extends Factory
{
    protected $model = Servico::class;

    public function definition(): array
    {
        return [
            'nome' => ucfirst($this->faker->unique()->word),
            'situacao' => 'ativo',
        ];
    }
}
