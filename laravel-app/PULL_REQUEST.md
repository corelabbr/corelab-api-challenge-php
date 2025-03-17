# README.md

## Introdução

Este projeto utiliza **Laravel** em conjunto com **Docker** e **Laravel Sail** para criar um ambiente de desenvolvimento eficiente e escalável. Este documento explica as vantagens de usar Laravel, Redis, e como o Sail facilita o uso do Docker.

## Vantagens do Laravel

**Laravel** é um framework PHP que se destaca por sua sintaxe expressiva e elegante. Aqui estão algumas razões para escolher o Laravel:

- **Facilidade de Uso**: Laravel oferece uma curva de aprendizado suave, permitindo que desenvolvedores iniciantes e experientes construam aplicações rapidamente.
- **Ecosistema Rico**: Com uma vasta gama de pacotes e bibliotecas, o Laravel facilita a adição de funcionalidades ao seu projeto.
- **Segurança**: O Laravel inclui recursos de segurança robustos, como proteção contra CSRF e XSS, que ajudam a proteger suas aplicações.
- **Artisan CLI**: A interface de linha de comando do Laravel, chamada Artisan, permite a automação de tarefas comuns, aumentando a produtividade.
- **Suporte a Testes**: O Laravel possui suporte integrado para testes, facilitando a criação de testes automatizados para garantir a qualidade do código.

## Por que usar Redis?

**Redis** é um armazenamento de estrutura de dados em memória, amplamente utilizado como um banco de dados, cache e broker de mensagens. Aqui estão algumas vantagens de usar Redis em sua aplicação Laravel:

- **Desempenho Rápido**: Redis é extremamente rápido, permitindo operações em milissegundos, o que é ideal para aplicações que exigem alta performance.
- **Cache Eficiente**: Usar Redis como cache pode melhorar significativamente o tempo de resposta da sua aplicação, reduzindo a carga no banco de dados.
- **Suporte a Estruturas de Dados**: Redis suporta várias estruturas de dados, como strings, hashes, listas e conjuntos, permitindo que você escolha a melhor forma de armazenar seus dados.
- **Persistência Opcional**: Embora seja um armazenamento em memória, o Redis oferece opções de persistência, permitindo que você salve dados em disco quando necessário.

## O que é Laravel Sail?

**Laravel Sail** é uma interface de linha de comando leve para interagir com o ambiente de desenvolvimento Docker padrão do Laravel. Ele fornece uma maneira simples de configurar e gerenciar sua aplicação Laravel em contêineres Docker, sem a necessidade de experiência prévia com Docker.

### Vantagens de Usar Laravel Sail com Docker

- **Configuração Simplificada**: Sail permite que você inicie rapidamente um ambiente de desenvolvimento com PHP, MySQL e Redis, sem precisar configurar manualmente os contêineres Docker.
- **Ambientes Isolados**: Cada serviço (como o banco de dados e o Redis) roda em seu próprio contêiner, garantindo que não haja conflitos entre dependências.
- **Facilidade de Uso**: Com comandos simples, você pode iniciar, parar e gerenciar sua aplicação, tornando o desenvolvimento mais ágil.
- **Integração com Docker**: Sail é projetado para funcionar perfeitamente com Docker, permitindo que você aproveite todos os benefícios da contêinerização, como portabilidade e escalabilidade.

## Estrutura do `docker-compose.yml`

O arquivo `docker-compose.yml` abaixo define os serviços necessários para rodar uma aplicação Laravel, incluindo o servidor web, banco de dados MySQL e Redis:

```yaml
services:
    laravel.test:
        build:
            context: ./vendor/laravel/sail/runtimes/8.4
            dockerfile: Dockerfile
            args:
                WWWGROUP: '${WWWGROUP}'
        image: sail-8.4/app
        extra_hosts:
            - 'host.docker.internal:host-gateway'
        ports:
            - '${APP_PORT:-80}:80'
            - '${VITE_PORT:-5173}:${VITE_PORT:-5173}'
        environment:
            WWWUSER: '${WWWUSER}'
            LARAVEL_SAIL: 1
            XDEBUG_MODE: '${SAIL_XDEBUG_MODE:-off}'
            XDEBUG_CONFIG: '${SAIL_XDEBUG_CONFIG:-client_host=host.docker.internal}'
            IGNITION_LOCAL_SITES_PATH: '${PWD}'
        volumes:
            - '.:/var/www/html'
        networks:
            - sail
        depends_on:
            - mysql
            - redis
    mysql:
        image: 'mysql/mysql-server:8.0'
        ports:
            - '${FORWARD_DB_PORT:-3306}:3306'
        environment:
            MYSQL_ROOT_PASSWORD: '${DB_PASSWORD}'
            MYSQL_ROOT_HOST: '%'
            MYSQL_DATABASE: '${DB_DATABASE}'
            MYSQL_USER: '${DB_USERNAME}'
            MYSQL_PASSWORD: '${DB_PASSWORD}'
            MYSQL_ALLOW_EMPTY_PASSWORD: 1
        volumes:
            - 'sail-mysql:/var/lib/mysql'
            - './vendor/laravel/sail/database/mysql/create-testing-database.sh:/docker-entrypoint-initdb.d/10-create-testing-database.sh'
        networks:
            - sail
        healthcheck:
            test:
                - CMD
                - mysqladmin
                - ping
                - '-p${DB_PASSWORD}'
            retries: 3
            timeout: 5s
    redis:
        image: 'redis:alpine'
        ports:
            - '${FORWARD_REDIS_PORT:-6379}:6379'
        volumes:
            - 'sail-redis:/data'
        networks:
            - sail
        healthcheck:
            test:
                - CMD
                - redis-cli
                - ping
            retries: 3
            timeout: 5s
networks:
    sail:
        driver: bridge
volumes:
    sail-mysql:
        driver: local
    sail-redis:
        driver: local











