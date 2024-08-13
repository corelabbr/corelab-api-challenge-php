# Corelab Notas

Este projeto consiste em uma aplicação web que permite aos usuários criar e gerenciar suas listas de tarefas (to-do lists). A aplicação é composta por duas partes principais:

- **Frontend**: Uma página web responsiva desenvolvida em React, que oferece uma interface interativa e amigável para os usuários criarem, visualizarem e gerenciarem suas listas de tarefas. O frontend é projetado para ser intuitivo e responsivo, garantindo uma boa experiência em diversos dispositivos.

- **Backend**: Uma API desenvolvida em PHP Laravel para armazenar e gerenciar as listas de tarefas dos usuários. O backend fornece endpoints para criar, ler, atualizar e excluir tarefas.

## Funcionalidades
- **Gerenciamento de tarefas**: Operações completas para criar, ler, atualizar e deletar tarefas.
- **Gerenciamento de Usuários**: Operações completas para criar, ler, atualizar e deletar usuários.
- **Autenticação e Autorização**: Mecanismos para registro, login e proteção de rotas.

## Tecnologias Utilizadas no Backend
- [Laravel](https://laravel.com/) Framework PHP para desenvolvimento de aplicações web, utilizado para construir a API e gerenciar a lógica de negócios do backend.
- [MySQL](https://www.mysql.com/) Sistema de gerenciamento de banco de dados relacional usado para armazenar dados da aplicação.
- [Docker](https://www.docker.com/) Plataforma para criar, implantar e executar aplicações em containers, garantindo que o ambiente de desenvolvimento e produção sejam consistentes.
- [Nginx](https://nginx.org/) Servidor web utilizado para servir a aplicação e gerenciar o tráfego HTTP.
- [PHP 7.4-FPM](https://www.php.net/) Versão do PHP com suporte a FastCGI Process Manager, otimizada para desempenho em ambientes de produção.

## Tecnologias Utilizadas no Frontend
- [Node.js](https://nodejs.org/pt) Ambiente de execução JavaScript no lado do servidor, utilizado para executar scripts JavaScript fora do navegador e gerenciar pacotes e dependências da aplicação através do npm (Node Package Manager).
- [React](https://react.dev/) Biblioteca JavaScript para construção de interfaces de usuário, utilizada para criar componentes de frontend e gerenciar o estado da aplicação.
- [Redux](https://redux.js.org/) Biblioteca para gerenciamento de estado global em aplicações JavaScript, usada para armazenar e gerenciar o estado da aplicação em uma store global.
- [Axios](https://axios-http.com/) Biblioteca para realizar requisições HTTP em JavaScript, usada para comunicação com APIs e gerenciamento de dados entre o frontend e o backend.
- [TypeScript](https://www.typescriptlang.org/) Superset do JavaScript que adiciona tipagem estática opcional, usado para melhorar a segurança e a robustez do código.
- [Bootstrap 5](https://getbootstrap.com/) Framework de CSS para design responsivo e estilização rápida, usado para estilizar e criar uma interface de usuário moderna e amigável.
- [Sass](https://sass-lang.com/) Pré-processador CSS que permite usar variáveis, aninhamento e outras funcionalidades avançadas, utilizado para escrever e manter o CSS da aplicação.

## Requisitos para rodar a aplicação
- **Docker**.
- **Docker Compose**.
#### Caso não use docker
#### Frontend
- **Node**.js: Versão 20.x.
- **npm**: Versão 10.x.
#### Backend
- **PHP**: Versão 7.4.
- **Composer**: Versão 2.x.
#### Banco de Dados
- **MySQL**: Versão 8.x.

## Instalação
Para começar a trabalhar com a aplicação, você precisará clonar os repositórios do frontend e do backend.
- **Frontend**: `git clone https://github.com/NikollasBeltrao/corelab-challenge-web-app-php.git`
- **Backend**: `git clone https://github.com/NikollasBeltrao/corelab-api-challenge-php.git`


### Backend
- No terminal navegue até o diretório do projeto `cd corelab-api-challenge-php`.
- Altere o arquivo `.env.example` para `.env`.
- No arquivo `.env`, altere as variáveis do banco para:
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=corelab_challenge
DB_USERNAME=root
DB_PASSWORD=root
```
#### Caso use docker

- Crie o container com `docker compose build` ou usando o *Makefile* `make build`.
- Inicie o container com `docker compose up` ou usando o *Makefile* `make up`.
- Instale as dependências  do composer com `docker compose exec api composer install` ou usando o *Makefile* `make composer-install`.
- Crie as tabelas no banco com `docker compose exec api php artisan migrate` ou  usando o *Makefile* `make migrate`.
- Gere uma `APP_KEY` no laravel com `docker compose exec api php artisan key:generate`  ou  usando o *Makefile* `make key-generate`.
- Teste o phpMyAdmin abrindo [http://localhost:8001/](http://localhost:8001/) no navegador.
- Teste o projeto abrindo [http://localhost:8000/](http://localhost:8000/) no navegador.

#### Caso não use docker
- Instale as dependências  do composer com `composer install`.
- Inicie o projeto com `php artisan serve`.
- Crie as tabelas no banco com `php artisan migrate`.
- Gere uma `APP_KEY` no laravel com `php artisan key:generate`.
- Teste o projeto abrindo [http://localhost:8000/](http://localhost:8000/) no navegador.

**OBS: Dependendo da versão do docker o comando pode ser `docker-compose`.**

### Frontend
- No terminal navegue até o diretório do projeto `cd corelab-challenge-web-app-php`.
- Altere o arquivo `.env.development.exemple` para `.env.development` e confira na variável `REACT_APP_API_URL` se o caminho e a porta para a API estão corretos.

#### Caso use docker
- Crie o container com `docker compose build` ou usando o *Makefile* `make build`.
- Inicie o container com `docker compose up` ou usando o *Makefile* `make up`.

#### Caso não use docker
- Instale as dependencias do node com `npm install`.
- Inicie o projeto com `npm start`.
- Acesse o projeto abrindo [http://localhost:3000/](http://localhost:3000/) no navegador.