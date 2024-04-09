# API de Notas - Solução

Esta é uma API de notas construída com Laravel para gerenciar suas notas. Você pode criar, ler, atualizar e excluir notas usando esta API.
Foi criado um arquivo para automação onde facilita a instalação da aplicação.

### Requisitos

Antes de começar, certifique-se de ter os seguintes requisitos instalados em seu sistema:

Docker  
Docker Compose (normalmente incluído na instalação do Docker Desktop)

### Configuração

Clone o repositório:

```bash
git clone https://github.com/thiagoleites/corelab-api-challenge-php.git
```

Crie um arquivo de ambiente .env a partir do .env.example:

```bash
make env
```

Instale as dependências e prepare o ambiente:

```bash
make prepare
```

Gerar Laravel Key

```bash
make key-generate
```

Atualizar dependências

```bash
make update
```

Rodar as Migrações

```bash
make migrate
```

Subir os containers

```bash
make up
```

Parar os containers

```bash
make down
```
