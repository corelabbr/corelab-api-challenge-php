# Desafio Core Lab - Backend

Este repositório contém uma API construída em **Laravel**, como parte de um desafio fornecido pela [CoreLab](https://www.corelab.com.br/pt).

## Tecnologias Utilizadas

As seguintes tecnologias foram empregadas na construção da aplicação:

- **NodeJS**: 20.17.0
- **MySQL**: 8.0
- **Laravel**: 11.0

## Configuração

*Esta aplicação utiliza o MySQL como banco de dados, mas você pode modificar as configurações no arquivo `.env` para usar outro banco de dados, se necessário.*

### Passos para Instalação

1. **Clone ou faça um fork deste repositório** para sua máquina.
   
2. **Abra o terminal** e certifique-se de que você está na raiz do projeto antes de rodar os seguintes comandos.

3. **Instale as dependências do projeto**:
   ```bash
   composer install
   ```

4. **Crie o arquivo `.env`** a partir do arquivo `.env.example`:
   - Renomeie o arquivo `.env.example` para `.env`.
   - Modifique as seguintes variáveis de acordo com sua configuração:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=laravel-corelab
   DB_USERNAME=laravel_user
   DB_PASSWORD=laravel_pass

   JWT_SECRET=jwtsecretencryptioncode
   ```

5. **Execute as migrações do banco de dados**:
   ```bash
   php artisan migrate
   ```

6. **Inicie a aplicação**:
   ```bash
   php artisan serve
   ```

### Rodando a Aplicação com Docker Compose

Para rodar tanto a aplicação quanto o banco de dados MySQL em containers Docker, siga os passos abaixo:

1. **Certifique-se de estar na pasta raiz do projeto, onde o arquivo `docker-compose.yml` está**, que define os serviços tanto da aplicação quanto do banco de dados MySQL.

2. **Execute o seguinte comando para construir e iniciar os containers** (aplicação e banco de dados):
   ```bash
   docker-compose up --build -d
   ```

3. Isso iniciará os containers da aplicação e do MySQL em modo destacado.

4. Os dados do banco de dados serão salvos em uma pasta chamada "db_data", que será criada dentro da pasta raiz do projeto.

### Parando e Removendo os Containers Docker

Para parar e remover os containers Docker, siga os passos abaixo:

1. **Pare os containers em execução**:
   ```bash
   docker-compose down
   ```

2. **Remova os containers parados e volumes** (opcional):
   ```bash
   docker-compose down --volumes
   ```

## Próximos Passos

Confira o repositório [Frontend](https://github.com/caio-ferreira-dev/corelab-challenge-web-app-php) para as instruções relacionadas à parte frontend da aplicação. 🚀
