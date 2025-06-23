<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestador;
use Illuminate\Support\Facades\Http;

class AtualizarCoordenadasPrestadores extends Command
{
    protected $signature = 'atualizar:coordenadas-prestadores';
    protected $description = 'Atualiza latitude e longitude dos prestadores com base no endereço cadastrado';

    public function handle()
    {
        $prestadores = Prestador::whereNull('latitude')
            ->orWhereNull('longitude')
            ->get();

        if ($prestadores->isEmpty()) {
            $this->info('Todos os prestadores já possuem coordenadas.');
            return;
        }

        foreach ($prestadores as $prestador) {
            $endereco = "{$prestador->endereco}, {$prestador->numero}, {$prestador->cidade} - {$prestador->estado}";

            $url = "https://nhen90f0j3.execute-api.us-east-1.amazonaws.com/v1/api/endereco/geocode/" . urlencode($endereco);

            $response = Http::withBasicAuth(
                'teste-Infornet',
                'c@nsulta-dad0s-ap1-teste-Infornet#24'
            )->get($url);

            if ($response->successful()) {
                $json = $response->json();

                $prestador->latitude = $json['lat'] ?? null;
                $prestador->longitude = $json['lon'] ?? null;
                $prestador->save();

                $this->info("✔ Coordenadas atualizadas para: {$prestador->nome}");
            } else {
                $this->warn("✖ Falha ao buscar coordenadas para: {$prestador->nome}");
            }
        }

        $this->info('Processo finalizado.');
    }
}
