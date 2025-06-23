<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Consulta de Prestadores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Buscar Prestadores</h2>

        <form id="form-busca" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Serviço</label>
                <select class="form-select" id="id_servico" required>
                    <option value="">Selecione...</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Token JWT</label>
                <input type="text" class="form-control" id="token" placeholder="Cole seu token aqui" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Endereço de Origem</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="endereco_origem" placeholder="Rua, número, cidade, UF">
                    <button type="button" class="btn btn-outline-secondary" onclick="buscarCoordenadas('origem')">Buscar</button>
                </div>
                <input type="text" class="form-control mt-2" id="origem" readonly placeholder="latitude, longitude">
            </div>

            <div class="col-md-6">
                <label class="form-label">Endereço de Destino</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="endereco_destino" placeholder="Rua, número, cidade, UF">
                    <button type="button" class="btn btn-outline-secondary" onclick="buscarCoordenadas('destino')">Buscar</button>
                </div>
                <input type="text" class="form-control mt-2" id="destino" readonly placeholder="latitude, longitude">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Buscar Prestadores</button>
            </div>
        </form>

        <hr class="my-4">
        <div id="resultado" class="mt-4"></div>
    </div>

    <script>
        async function carregarServicos() {
            const token = document.getElementById('token').value;
            if (!token) return;

            const res = await fetch('/api/servicos', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            });

            if (res.ok) {
                const json = await res.json();
                const select = document.getElementById('id_servico');
                select.innerHTML = '<option value="">Selecione...</option>';
                json.dados.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.nome;
                    select.appendChild(opt);
                });
            }
        }

        async function buscarCoordenadas(tipo) {
            const endereco = document.getElementById(`endereco_${tipo}`).value;
            const token = document.getElementById('token').value;
            const campoResultado = document.getElementById(tipo);

            if (!endereco || !token) {
                alert('Preencha o token e o endereço para buscar coordenadas.');
                return;
            }

            const res = await fetch(`/api/endereco/geocode/${encodeURIComponent(endereco)}`, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            });

            if (res.ok) {
                const json = await res.json();
                if (json.latitude && json.longitude) {
                    campoResultado.value = `${json.latitude},${json.longitude}`;
                } else {
                    campoResultado.value = '';
                    alert('Endereço não encontrado.');
                }
            } else {
                campoResultado.value = '';
                alert('Erro ao buscar coordenadas.');
            }
        }

        document.getElementById('form-busca').addEventListener('submit', async function(e) {
            e.preventDefault();

            const token = document.getElementById('token').value;
            const [olat, olng] = document.getElementById('origem').value.split(',').map(Number);
            const [dlat, dlng] = document.getElementById('destino').value.split(',').map(Number);
            const id_servico = document.getElementById('id_servico').value;

            const res = await fetch('/api/buscar-prestadores', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_servico: id_servico,
                    origem: {
                        cidade: "Cidade Origem",
                        UF: "UF",
                        latitude: olat,
                        longitude: olng
                    },
                    destino: {
                        cidade: "Cidade Destino",
                        UF: "UF",
                        latitude: dlat,
                        longitude: dlng
                    }
                })
            });

            const div = document.getElementById('resultado');
            div.innerHTML = '';

            if (res.ok) {
                const json = await res.json();
                div.innerHTML = `
                    <h5>Encontrados: ${json.quantidade}</h5>
                    <ul class="list-group mt-3">
                        ${json.dados.map(p => `
                            <li class="list-group-item">
                                <strong>${p.nome}</strong> — ${p.cidade} — ${p.distancia_total_km} km — R$ ${p.valor_total} —
                                <span class="badge bg-${p.status === 'online' ? 'success' : 'secondary'}">${p.status}</span>
                            </li>
                        `).join('')}
                    </ul>
                `;
            } else {
                div.innerHTML = `<div class="alert alert-danger">Erro ao buscar: ${res.status}</div>`;
            }
        });

        document.getElementById('token').addEventListener('change', carregarServicos);

        window.addEventListener('load', () => {
            const token = document.getElementById('token').value;
            if (token) carregarServicos();
        });
    </script>
</body>

</html>