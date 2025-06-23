<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servico;
use Illuminate\Support\Facades\DB;

class ServicoSeeder extends Seeder
{
    public function run()
    {
        DB::table('servicos')->truncate();

        $servicos = [
            ['nome' => 'Reboque', 'situacao' => 'ativo'],
            ['nome' => 'Chaveiro', 'situacao' => 'ativo'],
            ['nome' => 'Troca de Pneus', 'situacao' => 'ativo'],
            ['nome' => 'Carga de Bateria', 'situacao' => 'inativo'],
        ];

        foreach ($servicos as $servico) {
            Servico::create($servico);
        }
    }
}
