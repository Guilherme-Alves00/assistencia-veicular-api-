<?php

namespace Database\Seeders;

use App\Models\Prestador;
use App\Models\Servico;
use Illuminate\Database\Seeder;

class PrestadorSeeder extends Seeder
{
    public function run(): void
    {
        // Cria prestadores fictícios
        Prestador::factory(10)->create()->each(function ($prestador) {
            // Associa o prestador com um ou mais serviços
            $servicos = Servico::inRandomOrder()->take(2)->get();
            foreach ($servicos as $servico) {
                $prestador->servicos()->attach($servico->id, [
                    'km_saida' => rand(5, 30),
                    'valor_saida' => rand(80, 150),
                    'valor_km_excedente' => rand(3, 8),
                    'status' => 'online' // 👈 Garantindo prestadores online
                ]);
            }
        });
    }
}
