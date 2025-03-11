#Task App
Este projeto é um sistema web que possibilita aos usuários criar e administrar suas listas de afazeres. Ele é composto por duas partes principais:

- **Frontend**: Uma interface web adaptável, desenvolvida em React, projetada para ser intuitiva e compatível com diversos dispositivos. Os usuários podem criar, visualizar e organizar suas tarefas de maneira interativa.

- **Backend**: Uma API construída com PHP Laravel, responsável por armazenar e manipular as listas de afazeres. O backend fornece endpoints para adicionar, consultar, modificar e remover tarefas.

## Funcionalidades

- **Gerenciamento de tarefas**: Operações completas para criar, ler, atualizar, favoritar e deletar tarefas.

##Tecnologias Empregadas
**Backend**
Laravel – Framework PHP voltado para o desenvolvimento web, utilizado na construção da API e na administração da lógica do sistema.
MySQL – Banco de dados relacional usado para armazenar as informações das tarefas.
PHP 8.2 – Versão do PHP otimizada para alto desempenho, com suporte ao FastCGI Process Manager.

**Frontend**
React – Biblioteca JavaScript para criação de interfaces de usuário e gerenciamento de estados.
Axios – Biblioteca para efetuar requisições HTTP, empregada na comunicação entre o frontend e o backend.
TypeScript – Superset do JavaScript que adiciona tipagem estática, aprimorando a segurança e a robustez do código.
Sass – Pré-processador CSS que simplifica a manutenção e estruturação dos estilos da aplicação.

##Requisitos para execução
####Frontend
Node.js: Versão 20.x
npm: Versão 10.x
####Backend
PHP: Versão 8.x
Composer: Versão 2.x
####Banco de Dados
MySQL: Versão 8.x

##Instalação
Para iniciar, clone os repositórios do frontend e do backend:

###Frontend:
git clone https://github.com/Yuri-amaralsantos/corelab-challenge-web-app-php.git

###Backend:
git clone https://github.com/Yuri-amaralsantos/corelab-api-challenge-php.git

##Configuração do Backend
Duplique o arquivo .env.example e renomeie para .env:
cp .env.example .env  
Modifique o arquivo .env para configurar as variáveis do banco de dados:
DB_CONNECTION=mysql  
DB_HOST=db  
DB_PORT=3306  
DB_DATABASE=testtech  
DB_USERNAME=usuario  
DB_PASSWORD=senha

Instale as dependências do Composer:
composer install

Gere a chave da aplicação Laravel:
php artisan key:generate

Crie as tabelas no banco de dados:
php artisan migrate

Inicie o servidor:
php artisan serve

Acesse a aplicação em http://localhost:8000/ pelo navegador.

##Configuração do Frontend
Instale as dependências do Node.js:
npm install

Inicie o servidor do frontend:
npm start

Acesse a aplicação em http://localhost:3000/ pelo navegador.
