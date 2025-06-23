# Infornet Assistência API

API RESTful desenvolvida em Laravel para gerenciamento de prestadores de serviço, geolocalização e cálculo de custo-benefício para atendimentos assistenciais 24h.

---

## 🛠️ Tecnologias utilizadas

-   PHP 8.3+
-   Laravel 10.x
-   MySQL
-   JWT Auth (Autenticação)
-   API externa de Geocodificação
-   Bootstrap ou TailwindCSS (Design System via Laravel Views)

---

## Instalação do projeto

1. Clone o repositório:

```bash
git clone https://github.com/Guilherme-Alves00/assistencia-veicular-api-.git
cd assistencia-veicular-api-
```

2. Instale as dependências: composer install

3. Copie o arquivo .env e gere a key da aplicação:
cp .env.example .env
php artisan key:generate

4. Configure seu .env com os dados abaixo:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

 API_USUARIO=teste-Infornet
 
 API_SENHA=c@nsulta-dad0s-ap1-teste-Infornet#24

5. Rode as migrations e seeders:
php artisan migrate --seed

6. Inicie o servidor:
php artisan serve

° Endpoints principais
Método	Rota	Descrição
POST	/api/login	Autenticação e geração de token JWT
GET	/api/servicos	Retorna serviços ativos
GET	/api/buscar-coordenadas?endereco=...	Consulta latitude e longitude
POST	/api/buscar-prestadores	Busca prestadores com filtros e ordenação
Todas as rotas são protegidas via JWT. Autentique-se com o token retornado no login.

° Sobre o cálculo de distância
A distância total leva em conta:
Prestador → Origem
Origem → Destino
Destino → Prestador

Se a distância for maior que o km de saída, será aplicado o valor excedente por km, além do valor base mínimo (valor de saída).

° Usuário de teste incluído via Seeder
E-mail: teste@infornet.com
Senha: senha123

° Scripts e estrutura
Uso de Repository Pattern para separação de responsabilidades
Seeders para popular mais de 25 prestadores e múltiplos serviços
Código orientado a boas práticas e princípios SOLID

° Requisitos atendidos
✔ Laravel com MySQL ✔ Autenticação JWT ✔ API externa com Basic Auth ✔ Interface via Blade + AJAX ✔ Mínimo de dados exigidos no desafio ✔ Organização por camadas: Models, Services, Repositories, Controllers

Este projeto foi desenvolvido para o desafio técnico da Infornet Assistência.
```
