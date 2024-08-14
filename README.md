## Passo a passo para rodar o projeto
Clone o projeto
```sh
git clone https://github.com/gabrielmattia/teste-api.git teste-api
```
```sh
cd teste-api
```


Crie o Arquivo .env
```sh
cp .env.example .env
```


Atualize essas variáveis de ambiente no arquivo .env
```dosini
APP_NAME="API-CHALLENGE"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=ip_db
DB_PORT=3388
DB_DATABASE=nome_db
DB_USERNAME=nome
DB_PASSWORD=senha
```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acesse o container
```sh
docker-compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```


Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Gere a key do projeto Laravel
```sh
php artisan migrate
```

Acesse o projeto
[http://localhost:8989](http://localhost:8989)