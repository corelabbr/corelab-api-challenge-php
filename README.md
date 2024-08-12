# Desafio Backend - Corelab

API para o sistema de anotações, responsável por lidar com o gerenciamento das notas.

## Tecnologias

<ul>
    <li>Laravel</li>
    <li>MySQL</li>
</ul>

## Requisitos

<ul>
    <li>Composer</li>
    <li>PHP ^8.0</li>
    <li>GIT</li>
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

Agora está tudo pronto para rodar o projeto:
```bash
    php artisan serve
```
