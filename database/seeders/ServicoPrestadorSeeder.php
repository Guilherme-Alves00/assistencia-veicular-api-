<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prestador;
use App\Models\Servico;

class ServicoPrestadorSeeder extends Seeder
{
    public function run(): void
    {
        $servicos = Servico::all();

        Prestador::all()->each(function ($prestador) use ($servicos) {
            $prestador->servicos()->attach(
                $servicos->random(3)->pluck('id'),
                [
                    'km_saida' => rand(20, 40),
                    'valor_saida' => rand(100, 200),
                    'valor_km_excedente' => rand(6, 15),
                ]
            );
        });
    }
}
