# CoreLab API Todo-List 📝

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Redis](https://img.shields.io/badge/Redis-Alpine-DC382D?style=for-the-badge&logo=redis&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker&logoColor=white)

Uma poderosa API RESTful para gerenciamento de tarefas, construída com Laravel 12 e seguindo as melhores práticas de desenvolvimento. Este projeto implementa uma série de padrões de design para manter o código organizado, testável e fácil de manter.

## 📋 Índice

- [Visão Geral](#visão-geral)
- [Funcionalidades](#funcionalidades)
- [Começando](#começando)
  - [Pré-requisitos](#pré-requisitos)
  - [Instalação](#instalação)
  - [Configuração](#configuração)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Padrões de Design](#padrões-de-design)
- [Sistema de Perfis de Usuário](#sistema-de-perfis-de-usuário)
- [Cores e Favoritos](#cores-e-favoritos)
- [Endpoints da API](#endpoints-da-api)
- [Autenticação](#autenticação)
- [Testes](#testes)
- [Desenvolvimento](#desenvolvimento)
  - [Comandos Úteis](#comandos-úteis)
  - [Ferramentas de Qualidade de Código](#ferramentas-de-qualidade-de-código)
- [Deploy](#deploy)
- [Resolução de Problemas](#resolução-de-problemas)
- [Contribuindo](#contribuindo)
- [Licença](#licença)

## 📖 Visão Geral

Esta API permite gerenciar tarefas (to-do lists) com recursos avançados, incluindo:
- Múltiplos usuários com diferentes níveis de permissão
- Categorização visual de tarefas por cores
- Sistema de favoritos para acesso rápido
- Auditoria de mudanças
- Autenticação segura com Laravel Sanctum

Todo o projeto foi construído seguindo boas práticas de código, incluindo implementação de padrões de design como Repository, Service Layer, e Observer Pattern, além de TDD (Test-Driven Development).

## ✨ Funcionalidades

- **Gerenciamento de Tarefas**: Criar, visualizar, atualizar e excluir tarefas
- **Sistema de Perfis**: Três níveis de acesso (Admin, Gerente, Membro)
- **Personalização Visual**: 10 cores predefinidas para categorizar tarefas
- **Favoritos**: Marcar/desmarcar tarefas como favoritas para acesso rápido
- **Filtragem**: Buscar tarefas por status, datas e outros critérios
- **Autenticação**: Sistema seguro com tokens via Laravel Sanctum
- **Autorização**: Políticas de acesso baseadas em perfil
- **Auditoria**: Registro de todas as alterações nas tarefas
- **API Token**: Camada adicional de segurança para aplicações cliente
- **Documentação Interativa**: Interface Swagger para explorar a API

## 🚀 Começando

### Pré-requisitos

Para rodar este projeto, você precisa ter instalado:

- [Docker](https://www.docker.com/get-started) (para Laravel Sail)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/downloads)

Não é necessário instalar PHP, MySQL ou Redis localmente, pois o Laravel Sail (Docker) irá gerenciar essas dependências.

### Instalação

1. Clone o repositório: <br>
    1.1. Via HTTPS:
   ```bash
   git clone https://github.com/guilhermehub12/corelab-api.git
   cd corelab-api
   ```
    1.2. Via SSH:
   ```bash
   git clone git@github.com:guilhermehub12/corelab-api.git
   cd corelab-api
   ```

2. Crie o arquivo `.env` a partir do exemplo:
   ```bash
   cp .env.example .env
   ```

3. Inicie o ambiente de desenvolvimento com Laravel Sail:
   ```bash
   docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

    ou caso possua PHP instalado, utilize
    composer install

   ./vendor/bin/sail up -d
   ```

4. Instale as dependências:
   ```bash
   ./vendor/bin/sail composer install
   ```

5. Gere a chave da aplicação:
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

6. Execute as migrações e popule o banco de dados:
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

7. Gere a documentação da API:
   ```bash
   ./vendor/bin/sail artisan l5-swagger:generate
   ```

### Configuração

Abra o arquivo `.env` e ajuste as seguintes configurações:

#### Configurações Básicas
```
APP_NAME="CoreLab API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
```

#### Banco de Dados
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

#### Redis (para cache)
```
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

#### Token da API
```
API_TOKEN=seu_token_secreto_aqui
AUTH_TOKEN=seu_token_secreto_aqui
```

#### Configuração do Octane (swoole, frakenphp ou roadrunner)
```
OCTANE_SERVER=swoole
```

#### Configuração do Swagger
```
L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_CONST_HOST=http://localhost
```

## 📂 Estrutura do Projeto

```
app/
├── Enums/            # Enumerações como ProfileEnum
├── Http/
│   ├── Controllers/  # Controllers da API
│   ├── Middleware/   # Middlewares (EnsureApiToken, etc.)
│   ├── Requests/     # Form Requests para validação
│   └── Resources/    # Transformadores de recursos da API
├── Models/           # Modelos Eloquent (Task, User, etc.)
├── Observers/        # Observadores de modelo
├── Policies/         # Políticas de autorização
├── Providers/        # Service Providers
├── Repositories/     # Camada de repositório para acesso a dados
└── Services/         # Camada de serviço com lógica de negócios
```

## 🧩 Padrões de Design

O projeto utiliza diversos padrões de design para manter o código organizado e de fácil manutenção:

### 1. MVC (Model-View-Controller)
- **Models**: Representam os dados e as regras de negócio
- **Controllers**: Processam requisições e retornam respostas
- **Views**: Substituídas por Resources em APIs RESTful

### 2. Repository Pattern
- Abstrai o acesso a dados
- Permite trocar a fonte de dados sem afetar a lógica de negócios
- Centraliza operações de banco de dados

### 3. Service Layer
- Encapsula a lógica de negócios
- Mantém os controllers enxutos
- Facilita testes unitários

### 4. Observer Pattern
- Monitora eventos do ciclo de vida dos modelos
- Registra logs de atividade
- Implementa ações automáticas em resposta a eventos

### 5. Policy Pattern
- Gerencia a lógica de autorização
- Aplica permissões baseadas em perfis
- Centraliza as regras de acesso

## 👥 Sistema de Perfis de Usuário

O sistema implementa três níveis de perfis de usuários, cada um com diferentes permissões:

### 👑 Admin
- Acesso completo ao sistema
- Pode visualizar, criar, editar e excluir qualquer tarefa
- Pode atribuir tarefas a qualquer usuário
- Maior limite de taxa de requisições

### 👨‍💼 Manager (Gerente)
- Pode visualizar todas as tarefas
- Pode criar tarefas para si ou para outros usuários
- Pode editar e excluir tarefas de qualquer usuário
- Limite médio de taxa de requisições

### 👤 Member (Membro)
- Visualiza apenas suas próprias tarefas
- Pode criar tarefas apenas para si mesmo
- Pode editar e excluir apenas suas próprias tarefas
- Limite mais restrito de taxa de requisições

### Usuários padrões para teste
Os seguintes usuários são criados pelo seeder para testes:

- Admin: admin@email.com (senha: password)
- Gerente: manager@email.com (senha: password)
- Membro: member@email.com (senha: password)

## 🎨 Cores e Favoritos

### Sistema de Cores
O sistema oferece 10 cores predefinidas para personalizar a aparência das tarefas:

- **Vermelho (#FF5252)** - Para tarefas urgentes
- **Azul (#4285F4)** - Cor padrão para tarefas normais
- **Verde (#0F9D58)** - Para tarefas concluídas ou em andamento
- **Amarelo (#FFCA28)** - Para tarefas de atenção moderada
- **Roxo (#9C27B0)** - Para tarefas criativas
- **Laranja (#FF7043)** - Para tarefas de prioridade média
- **Ciano (#00BCD4)** - Para tarefas relacionadas a comunicação
- **Rosa (#E91E63)** - Para tarefas pessoais
- **Verde-água (#26A69A)** - Para tarefas de bem-estar
- **Cinza (#757575)** - Para tarefas neutras ou de baixa prioridade

### Sistema de Favoritos
- Os usuários podem marcar qualquer tarefa como favorita para acesso rápido
- Uma tarefa pode ser favoritada por vários usuários
- Existe um endpoint específico para listar todas as tarefas favoritas do usuário autenticado

## 🔌 Endpoints da API

### Autenticação
- `POST /api/register` - Registrar um novo usuário
- `POST /api/login` - Login de usuário
- `POST /api/logout` - Logout (requer autenticação)
- `GET /api/user` - Obter informações do usuário autenticado

### Tarefas
- `GET /api/tasks` - Obter todas as tarefas (filtradas por perfil)
- `POST /api/tasks` - Criar uma nova tarefa
- `GET /api/tasks/{id}` - Obter uma tarefa específica
- `PUT /api/tasks/{id}` - Atualizar uma tarefa
- `DELETE /api/tasks/{id}` - Excluir uma tarefa
- `GET /api/tasks/status/{status}` - Obter tarefas por status

### Cores de Tarefas
- `GET /api/tasks/colors` - Listar todas as cores disponíveis
- `PUT /api/tasks/{id}/color/{colorId}` - Atualizar a cor de uma tarefa

### Favoritos
- `GET /api/tasks/favorites` - Listar tarefas favoritas do usuário
- `POST /api/tasks/{id}/favorite` - Alternar status de favorito de uma tarefa

### Documentação da API
A documentação interativa da API está disponível em:
```
http://localhost/api/doc
```

## 🔐 Autenticação

O sistema utiliza dois mecanismos de autenticação:

### 1. Token Bearer (Laravel Sanctum)
Para autenticar usuários individuais:

1. Faça login para obter um token:
   ```http
   POST /api/login
   Content-Type: application/json
   
   {
     "email": "admin@email.com",
     "password": "password"
   }
   ```

2. Use o token nas requisições:
   ```http
   GET /api/tasks
   Authorization: Bearer seu_token_aqui
   ```

### 2. Token de API
Para autenticar aplicações cliente (camada adicional de segurança):

```http
GET /api/tasks
Authorization: Bearer seu_token_usuario
X-API-TOKEN: seu_token_api
```

O token de API deve ser configurado no arquivo `.env` como `API_TOKEN=seu_token_aqui`.

## 🧪 Testes

O projeto inclui testes abrangentes para todas as funcionalidades:

### Executar todos os testes
```bash
./vendor/bin/sail artisan test
```

### Executar testes específicos
```bash
# Testes de autenticação
./vendor/bin/sail artisan test --filter='Tests\\Feature\\Auth'

# Testes de tarefas
./vendor/bin/sail artisan test --filter='Tests\\Feature\\Task'

# Um teste específico
./vendor/bin/sail artisan test --filter=TaskShowTest
```

### Testes com cobertura
```bash
XDEBUG_MODE=coverage ./vendor/bin/sail artisan test --coverage-html coverage
```

## 💻 Desenvolvimento

### Comandos Úteis

#### Artisan
```bash
# Listar todas as rotas
./vendor/bin/sail artisan route:list

# Criar um novo controller
./vendor/bin/sail artisan make:controller Api/NovoController --api

# Criar um novo model com migration, factory e seeder
./vendor/bin/sail artisan make:model NovoModel -mfs

# Limpar caches
./vendor/bin/sail artisan optimize:clear
```

#### Banco de Dados
```bash
# Refresh do banco de dados (apaga tudo e recria)
./vendor/bin/sail artisan migrate:fresh --seed

# Adicionar uma nova coluna a uma tabela existente
./vendor/bin/sail artisan make:migration add_coluna_to_tabela --table=tabela
```

#### Cache
```bash
# Limpar cache de configuração
./vendor/bin/sail artisan config:clear

# Limpar cache de rotas
./vendor/bin/sail artisan route:clear
```

### Ferramentas de Qualidade de Código

O projeto utiliza várias ferramentas para garantir a qualidade do código:

#### Laravel Pint (Formatação de código)
```bash
# Verificar formatação
./vendor/bin/sail composer pint

# Corrigir formatação
./vendor/bin/sail composer pint:fix
```

#### Larastan (Análise estática)
```bash
./vendor/bin/sail composer analyse
```

#### Rector (Refatoração automatizada)
```bash
# Verificar possíveis refatorações
./vendor/bin/sail composer fix-rector

# Aplicar refatorações
./vendor/bin/sail composer fix
```

## 🚢 Deploy

Para fazer deploy do projeto em produção:

### 1. Preparar o ambiente
- Certifique-se de que o servidor atende aos requisitos (PHP 8.3+, MySQL 8.0+, Redis)
- Configure o servidor web (Nginx ou Apache)
- Configure o SSL (recomendado para produção)

### 2. Clonar e configurar o projeto
```bash
git clone https://github.com/guilhermehub12/corelab-api.git
cd corelab-api
composer install --no-dev --optimize-autoloader
cp .env.example .env
# Edite o arquivo .env com as configurações de produção
php artisan key:generate
```

### 3. Configurar o banco de dados
```bash
php artisan migrate --force
```

### 4. Otimizar para produção
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### CI/CD
O projeto inclui configuração para GitHub Actions, que:
1. Executa testes automaticamente em pull requests
2. Faz deploy automático para staging quando um commit é feito na branch `develop`
3. Faz deploy automático para produção quando um commit é feito na branch `main`

## 🔧 Resolução de Problemas

### Problema: Erro ao executar migrações
**Solução**: Verifique as configurações de banco de dados no arquivo `.env` e certifique-se de que o banco de dados existe.

```bash
./vendor/bin/sail restart
./vendor/bin/sail artisan migrate:fresh --seed
```

### Problema: Erros de token de API
**Solução**: Verifique se o token de API está configurado no arquivo `.env` e se está sendo enviado corretamente nos headers das requisições.

## 🤝 Contribuindo

Contribuições são bem-vindas! Para contribuir:

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/amazing-feature`)
3. Faça commit das suas mudanças (`git commit -m 'Add some amazing feature'`)
4. Faça push para a branch (`git push origin feature/amazing-feature`)
5. Abra um Pull Request

### Diretrizes para contribuição
- Siga o padrão de codificação do Laravel
- Escreva testes para todas as novas funcionalidades
- Atualize a documentação quando necessário
- Verifique se todos os testes passam antes de enviar um PR

## 📄 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

---

Desenvolvido com 💙 por [Guilherme Delmiro](https://github.com/guilhermehub12)