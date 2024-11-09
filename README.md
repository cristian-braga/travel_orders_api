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

### ⚙️ Executando testes

Popule a base de dados para testar os endpoints:
```sh
php artisan db:seed
```

Para rodar os teste do PHPUnit:
```sh
php artisan test
```

---
Acesse a página de Welcome do Laravel no navegador:
[http://localhost:8000](http://localhost:8000)
