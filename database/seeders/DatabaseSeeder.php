<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Servico;
use App\Models\Prestador;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuário de login
        User::create([
            'name' => 'Admin',
            'email' => 'admin@infornet.com.br',
            'password' => Hash::make('123456'),
        ]);

        // Serviço
        $servico = Servico::create([
            'nome' => 'Reparo Hidráulico',
        ]);

        // Prestador
        $prestador = Prestador::create([
            'nome' => 'Sr. Mário Cortês Sobrinho',
            'logradouro' => 'Av. Giovane Garcia',
            'bairro' => 'do Leste',
            'numero' => '697',
            'latitude' => -17.017106,
            'longitude' => -56.932316,
            'cidade' => 'São Carolina',
            'UF' => 'ES',
            'situacao' => 'inativo',
        ]);

        // Associação com status "online"
        $prestador->servicos()->attach($servico->id, [
            'status' => 'online',
            'km_saida' => 10,
            'valor_saida' => 50.00,
            'valor_km_excedente' => 3.50,
        ]);
    }
}
