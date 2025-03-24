# Pull Request: Task Management Backend

## 🚀 Descrição do Backend

### Visão Geral
Implementação do backend do sistema de gerenciamento de tarefas utilizando Laravel e MySQL.

## 🔧 Funcionalidades Implementadas

### Modelo Task
- Criação de modelo `Task` com atributos:
  - `title`
  - `description`
  - `is_favorite`
  - `background_color`

### Controllers
- `TaskController` com métodos CRUD:
  - `index()`: Listar tarefas
  - `store()`: Criar tarefa
  - `update()`: Atualizar tarefa
  - `destroy()`: Deletar tarefa

### Migrations
- Criação de tabela `tasks` com campos:
  - `id`
  - `title`
  - `description`
  - `is_favorite`
  - `background_color`
  - `created_at`
  - `updated_at`
  - `soft_delete`

### Seeder e Factory
- Criacção de uma factory `TaskFactory`, e uma seeder `TaskSeeder`, que cria 10 tasks
- 
### Rotas API
- Endpoints implementados:
  - `GET /api/tasks`
  - `POST /api/tasks`
  - `PUT /api/tasks/{id}`
  - `DELETE /api/tasks/{id}`

## 🔍 Melhorias Futuras
- Implementar autenticação
- Implementar cache


## 📦 Tecnologias
- Laravel 11.1
- PHP 8.2
- MySQL
- Eloquent ORM

## Como Configurar o Projeto

1. **Clone o repositório**:
   ```bash
   git clone https://github.com/anthoniusdev/corelab-api-challenge-php.git
   cd teste-laravel

2. **Instale as dependências**:
   
    Dentro da pasta do projeto, execute o seguinte comando para instalar as dependências do Laravel:
    ```bash
    composer install

3. **Configure as variáveis de ambiente**:

   Copie o arquivo ```.env.example``` para ```.env```.
    ```bash
    cp .env.example .env
    ```
   
   Em seguida abra o arquivo `.env` em um editor de texto de sua preferência e preencha as variáveis existentes abaixo:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nome_do_banco
    DB_USERNAME=nome_do_usuario
    DB_PASSWORD=senha
    ```
    - Certifique-se de substituir os valores corretamente.
  

4. **Gerar Chave do Aplicativo**:
   
    O Laravel exige uma chave única para criptografia. Gere a chave com:
     ```bash
     php artisan key:generate
     ```
     
5. **Configurar o Banco de Dados**:

    Se ainda não tiver criado o banco, faça isso no MySQL com:
    ```sql
    CREATE DATABASE nome_do_banco;
    ```
    - Certifique-se de substituir os valores corretamente.
      
    De volta ao diretório do projeto, execute o seguinte comando para executar as migrações que criam as tabelas:
    ```bash
    php artisan migrate
    ```

    Execute o seguinte comando para povoar o banco de dados:
    ```bash
    php artisan db:seed
    ```
6. **Execute o Projeto**
   
   Agora, para executar o servidor laravel:
   ```bash
   php artisan serve
   ```

---
