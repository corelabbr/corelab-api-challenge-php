# Desafio Backend - Corelab

API para o sistema de anotações, responsável por lidar com o gerenciamento das notas.

## Tecnologias

<ul>
    <li><a href='https://laravel.com/'>Laravel</a></li>
    <li><a href='https://www.mysql.com/'>MySQL</a></li>
</ul>

## Requisitos

<ul>
    <li><a href='https://getcomposer.org/'>Composer</a></li>
    <li><a href='https://www.php.net/downloads.php'>PHP 8.0 ou superior</a></li>
    <li><a href='https://git-scm.com/'>GIT</a></li>
</ul>

## Instalação

Faça o clone do projeto:
```bash
    git clone https://github.com/FelipePinha/corelab-api-challenge-php
```

Navegue até a pasta e faça a instalação das dependências com o composer:
```bash
    composer install
```

Faça uma cópia do arquivo .env.example e substitua as informações do banco de dados:

```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=corelab
    DB_USERNAME=root
    DB_PASSWORD=
```

Gere a chave do projeto:
```bash
    php artisan key:generate
```

Realize as migrations:
```bash
    php artisan migrate
```

Execute o projeto:
```bash
    php artisan serve
```
