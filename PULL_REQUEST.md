# CoreLab API Challenge (PHP)

Este repositório contém uma API desenvolvida em Laravel como parte do desafio CoreLab.

## Requisitos

Antes de iniciar, certifique-se de ter os seguintes requisitos instalados:

- PHP 8.4+
- Composer
- PostgreSQL
- Laravel 10+
- Docker (opcional, para ambiente conteinerizado)

## Instalação

1. Clone o repositório:
   ```sh
   git clone https://github.com/Tielson/desafio-corelab.git
   cd desafio-corelab/corelab-api-challenge-php
   ```

2. Instale as dependências:
   ```sh
   composer install
   ```

3. Copie o arquivo de configuração e configure as variáveis de ambiente:
   ```sh
   cp .env.example .env
   ```
   Atualize o `.env` com as informações do banco de dados, por exemplo:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=corelab
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

4. Gere a chave da aplicação:
   ```sh
   php artisan key:generate
   ```

5. Execute as migrações e seeders:
   ```sh
   php artisan migrate:fresh --seed
   ```

## Uso

Para iniciar o servidor local, execute:
```sh
php artisan serve
```
A API estará disponível em `http://127.0.0.1:8000`

### Testando a API

Você pode usar **Postman**, **Insomnia** ou **cURL** para testar os endpoints.

Exemplo de requisição para listar itens:
```sh
curl -X GET http://127.0.0.1:8000/api/items
```

## Estrutura do Projeto

- `app/Models/Item.php` - Modelo principal para os itens.
- `database/migrations/` - Arquivos de migração do banco de dados.
- `database/seeders/ItemsSeeder.php` - Seeder para popular o banco.
- `routes/api.php` - Definição das rotas da API.

## Problemas Comuns

- **Erro ao rodar os seeders**: Certifique-se de que o `ItemsSeeder` está no diretório `database/seeders/` e rode:
  ```sh
  composer dump-autoload
  php artisan db:seed --class=ItemsSeeder
  ```

- **Banco de dados não populado**: Rode o seguinte comando:
  ```sh
  php artisan migrate:fresh --seed
  ```

## Docker Configuration

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: laravel_react_app
    networks:
      - app_network
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - .:/var/www
      - /var/www/vendor  # Add this to preserve container's vendor dir
      - /var/www/node_modules
    ports:
      - "8000:8000"  # Laravel
      - "5173:5173"  # React
    environment:
      - APP_ENV=local
      - APP_DEBUG=true
      - APP_KEY
    depends_on:
      - db

  db:
    image: postgres:16
    networks:
      - app_network
    container_name: laravel_db
    restart: unless-stopped
    environment:
      POSTGRES_DB: laravel
      POSTGRES_USER: filipe
      POSTGRES_PASSWORD: 123456
      POSTGRES_INITDB_ARGS: "--auth-host=md5 --auth-local=md5"
    volumes:
      - db_data:/var/lib/postgresql/data
    ports:
      - "5432:5432"

volumes:
  db_data:
networks:
  app_network:
    driver: bridge
```

## Dockerfile

```dockerfile
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \  
    libzip-dev \
    unzip \
    curl \
    git \
    && docker-php-ext-install zip pdo pdo_pgsql  

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY composer.json ./

RUN composer install --no-interaction --no-scripts

COPY . .

RUN composer install --no-interaction && \
    composer dump-autoload --optimize

RUN npm install --force && \
    npm run build

EXPOSE 8000 5173

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8000 & npm run dev"]
```

