# Guia de Inicialização do Projeto

Este documento explica como iniciar e configurar corretamente o projeto Laravel e o frontend React.

## Backend - Laravel

### Pré-requisitos
- Docker e Docker Compose instalados

### Passos para iniciar o backend
1. Copiar o arquivo de ambiente:
   ```sh
   cp .env.example .env
   ```
2. Gerar a chave da aplicação:
   ```sh
   ./vendor/bin/sail artisan key:generate
   ```
3. Subir os containers com Docker Compose:
   ```sh
   ./vendor/bin/sail up -d
   ```
4. Executar as migrações do banco de dados:
   ```sh
   ./vendor/bin/sail migrate
   ```

O backend contém:
- Requests
- Models
- Factories
- Testes
- Autenticação

## Frontend - React

### Pré-requisitos
- Node.js instalado

### Passos para iniciar o frontend
1. Copiar o arquivo de ambiente:
   ```sh
   cp .env.example .env
   ```
2. Confirmar a URL do backend configurada no arquivo `.env` do frontend, garantindo que está apontando para o container do Laravel.
3. Instalar as dependências:
   ```sh
   npm install
   ```
4. Rodar o projeto em ambiente de desenvolvimento:
   ```sh
   npm run dev
   ```

O frontend foi desenvolvido utilizando:
- Vite
- Tailwind CSS
- React

A estrutura foi projetada para ser escalável e utilizar ao máximo os recursos que o React disponibiliza.

---

Com esses passos, o projeto estará configurado e pronto para desenvolvimento. Caso encontre algum problema, verifique se os serviços estão rodando corretamente e se os arquivos `.env` estão configurados corretamente. 🚀

