# Projeto API [Laravel 11](https://laravel.com/) com Docker

Projeto simples de um microsserviço em Laravel para gerenciar pedidos de viagem corporativa.

## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento, avaliação e teste.

### 📋 Pré-requisitos

Para executar a aplicação:
- [Docker](https://www.docker.com/)

Caso queira testar os endpoints da API:
- [Insomnia](https://insomnia.rest/download)
- [Postman](https://www.postman.com/)

### 🔧 Instalação

Clone o repositório:
```sh
git clone https://github.com/cristian-braga/travel_orders_api.git travel_orders_api
```

Entre na pasta do projeto:
```sh
cd travel_orders_api
```

Crie o arquivo com as variáveis de ambiente (.env):
```sh
cp .env.example .env
```

Atualize as variáveis de ambiente (.env) com os seguintes dados:
```dosini
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=travel_orders
DB_USERNAME=username
DB_PASSWORD=userpass

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
```

Suba os containers do projeto:
```sh
docker-compose up -d
```

Acesse o container app no terminal:
```sh
docker-compose exec app bash
```

Instale as dependências do projeto:
```sh
composer install
```

Gere a key do projeto Laravel:
```sh
php artisan key:generate
```

Gere a key do JWT para criação de tokens:
```sh
php artisan jwt:secret
```

Execute as migrations para criar a base de dados e as tabelas:
```sh
php artisan migrate
```

Popule a base de dados para testar os endpoints:
```sh
php artisan db:seed
```

## 📄 Endpoints

### Autenticação:

```sh
POST api/login
```
  - Realiza o login do usuário e retorna um token de autenticação.
  - Parâmetros:
    - `email`
    - `password`
  - Resposta:
    - `access_token`
    - **401 Unauthorized**: Se as credenciais forem inválidas.

```sh
POST api/logout
```
  - Realiza o logout do usuário.
  - Requer autenticação via token (Bearer token).
  - Resposta:
    - **200 OK**: Retorna uma mensagem de sucesso indicando que o logout foi realizado.
    - **401 Unauthorized**: Se o token fornecido não for válido.

### Pedidos de Viagem:

**Autenticação necessária**: Todos os endpoints abaixo requerem autenticação via token (usuário logado).

```sh
GET api/orders
```
  - Lista todos os pedidos de viagem.
  - Filtra pelo `status` (solicitado, aprovado, cancelado): `?status={status}`.
  - Resposta:
    - **200 OK**: Retorna uma lista de pedidos de viagem.
    - **401 Unauthorized**: Se o usuário não estiver autenticado.

```sh
POST api/orders
```
  - Cria um novo pedido de viagem.
  - Parâmetros:
    - `solicitante`
    - `destino`
    - `data_ida`
    - `data_volta`
  - Resposta:
    - **201 Created**: Retorna os dados do pedido de viagem recém-criado.
    - **422 Unprocessable Content**: Se algum dos parâmetros obrigatórios estiver ausente ou for inválido.

```sh
GET api/orders/{order}
```
  - Exibe os detalhes de um pedido de viagem específico.
  - Parâmetros:
    - `order`: ID do pedido de viagem.
  - Resposta:
    - **200 OK**: Retorna os detalhes do pedido.
    - **404 Not Found**: Se o pedido de viagem com o ID fornecido não existir.

```sh
PUT api/orders/{order}
```
  - Atualiza um pedido de viagem específico.
  - Parâmetros:
    - `order`: ID do pedido de viagem.
    - `status`
  - Resposta:
    - **200 OK**: Retorna os dados atualizados do pedido de viagem.
    - **404 Not Found**: Se o pedido de viagem com o ID fornecido não existir.
    - **422 Unprocessable Content**: Se o parâmetro `status` for inválido.

## ⚙️ Executando testes

Para rodar os teste do PHPUnit:
```sh
php artisan test
```

---
Acesse a página de Welcome do Laravel no navegador:
[http://localhost:8000](http://localhost:8000)
