# CoreNotes | API de Bloco de notas

Esta é uma API para um bloco de notas simples, construída usando Laravel. A API permite aos usuários autenticados criar, ler, atualizar e deletar notas. Também oferece funcionalidades de registro, login e gerenciamento de contas de usuário com autenticação via JWT.

## Aplicativo Java

Este repositório também inclui um aplicativo Java que consome a API de Bloco de Notas. O aplicativo permite que você interaja com a API de maneira simples e eficiente.

- **Repositório do Aplicativo Java:** [Clique aqui para acessar o repositório](https://github.com/iCrowleySHR/notepad.git)

- ## Aplicação React

Este repositório também inclui um Aplicação React que consome a API de Bloco de Notas.

- **Repositório: ** [Clique aqui para acessar o repositório](https://github.com/iCrowleySHR/corelab-challenge-web-app-php)




## Requisitos

- PHP >= 8.3.4
- Composer
- Laravel 11.4.0
- MySQL

## Instalação

1. Instale as dependências:
    ```bash
    composer install
    ```
2. Copie o arquivo `.env.example` para `.env` e configure suas variáveis de ambiente:
    ```bash
    cp .env.example .env
    ```
3. Gere a chave da aplicação:
    ```bash
    php artisan key:generate
    ```
4. Configure seu banco de dados no arquivo `.env` e execute as migrações:
    ```bash
    php artisan migrate
    ```

5. Instale o pacote JWT Auth:
    ```bash
    composer require tymon/jwt-auth
    php artisan jwt:secret
    ```
    
6. Rode o servidor local:
    ```bash
    php artisan serve
    ```

## Endpoints

### Usuários

#### Registrar Usuário

- **URL:** `http://localhost/api_notepad/public/api/v1/users/`
- **Método:** `POST`
- **Parâmetros:**
  - `name`: Nome do usuário
  - `email`: Email do usuário
  - `password`: Senha do usuário
- **Exemplo de Request:**
    ```json
    {
        "name": "John Doe",
        "email": "john@example.com",
        "password": "password"
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
        "message": "Usuário registrado com sucesso!"
    }
    ```

#### Login

- **URL:** `http://localhost/api_notepad/public/api/v1/users/validate`
- **Método:** `POST`
- **Parâmetros:**
  - `email`: Email do usuário
  - `password`: Senha do usuário
- **Exemplo de Request:**
    ```json
    {
        "email": "john@example.com",
        "password": "password"
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
        "success": "Usuário autenticado",
        "name": "Jorge da Silva Pereira",
        "email": "teste@gustavo.com",
        "id": 3,
        "created_at": "2024-05-16T00:19:06.000000Z",
        "updated_at": "2024-05-16T00:19:06.000000Z",
        "token": "{token}",
        "token_type": "bearer"
    }
    ```

#### Atualizar Usuário

- **URL:** `http://localhost/api_notepad/public/api/v1/users/`
- **Método:** `PUT`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Parâmetros:**
  - `name`: Nome do usuário
  - `telephone`: Telefone
  - `email`: Email
  - `new_password`: Nova senha (se for trocar a senha)
  - `current_password`: Senha atual (necessária para troca de senha)
- **Exemplo de Request:**
    ```json
    {
        "name": "João da Silva",
        "telephone": "123456789",
        "email": "joao@example.com",
        "new_password": "newpassword",
        "current_password": "oldpassword"
    }
    ```

#### Deletar Usuário

- **URL:** `http://localhost/api_notepad/public/api/v1/users/`
- **Método:** `DELETE`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Resposta de Sucesso:**
    ```json
    {
        "success": "Conta apagada com sucesso."
    }
    ```

#### Logout

- **URL:** `http://localhost/api_notepad/public/api/v1/users/logout`
- **Método:** `POST`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Resposta de Sucesso:**
    ```json
    {
        "success": "Logout bem sucedido."
    }
    ```

### Notas

#### Listar Notas

- **URL:** `/api/notes`
- **Método:** `GET`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Resposta de Sucesso:**
    ```json
    [
        {
            "id": 1,
            "title": "Minha Primeira Nota",
            "content": "Conteúdo da nota",
            "created_at": "2023-05-15T14:00:00.000000Z",
            "updated_at": "2023-05-15T14:00:00.000000Z",
            "favorite": false,
            "color": "#FFFF"
        }
    ]
    ```

#### Criar Nota

- **URL:** `http://localhost/api_notepad/public/api/v1/notes`
- **Método:** `POST`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Parâmetros:**
  - `title`: Título da nota
  - `content`: Conteúdo da nota
  - `id_user`: Usuário que criou a nota
- **Exemplo de Request:**
    ```json
    {
        "title": "Minha Primeira Nota",
        "content": "Conteúdo da nota",
        "id_user": "1"
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
        "success": "Anotação salva!"
    }
    ```

#### Visualizar Nota

- **URL:** `http://localhost/api_notepad/public/api/v1/notes/{id}`
- **Método:** `GET`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Resposta de Sucesso:**
    ```json
    {
        "id": 1,
        "title": "Minha Primeira Nota",
        "content": "Conteúdo da nota",
        "favorite": false,
        "color": "#FFFF",
        "created_at": "2023-05-15T14:00:00.000000Z",
        "updated_at": "2023-05-15T14:00:00.000000Z"
    }
    ```

#### Atualizar Nota

- **URL:** `http://localhost/api_notepad/public/api/v1/notes/{id}`
- **Método:** `PUT`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Parâmetros:**
  - `title`: Título da nota
  - `content`: Conteúdo da nota
- **Exemplo de Request:**
    ```json
    {
        "title": "Título Atualizado",
        "content": "Conteúdo atualizado da nota"
    }
    ```

#### Deletar Nota

- **URL:** `http://localhost/api_notepad/public/api/v1/notes/{id}`
- **Método:** `DELETE`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Resposta de Sucesso:**
    ```json
    {
        "success": "Nota apagada"
    }
    ```

#### Pesquisar Notas

- **URL:** `/api/notes/search/{title}`
- **Método:** `GET`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Parâmetros:**
  - `title`: Título da nota (pode ser parcial)
- **Resposta de Sucesso:**
    ```json
    [
        {
            "id": 1,
            "title": "Minha Primeira Nota",
            "content": "Conteúdo da nota",
            "created_at": "2023-05-15T14:00:00.000000Z",
            "updated_at": "2023-05-15T14:00:00.000000Z",
            "favorite": false,
            "color": "#FFFF",
        }
    ]
    ```

## Observações

- O sistema utiliza **JWT** para autenticação, e é necessário gerar o token de autenticação ao fazer login.
- Para mais detalhes sobre a implementação, consulte o código-fonte.
