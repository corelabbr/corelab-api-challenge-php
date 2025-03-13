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
''   php artisan migrate
   ```

6. **Inicie a aplicação**:
   ```bash
   php artisan serve
   ```

## Próximos Passos

Confira o repositório [Frontend](https://github.com/caio-ferreira-dev/corelab-challenge-web-app-php) para as instruções relacionadas à parte frontend da aplicação. 🚀
