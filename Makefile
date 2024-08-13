CONTAINER_NAME = api
DOCKER_COMP = docker compose

build:
	$(DOCKER_COMP) build

up:
	$(DOCKER_COMP) up -d

down:
	$(DOCKER_COMP) down

migrate:
	$(DOCKER_COMP) exec $(CONTAINER_NAME) php artisan migrate

seed:
	$(DOCKER_COMP) exec $(CONTAINER_NAME) php artisan db:seed

test:
	$(DOCKER_COMP) exec $(CONTAINER_NAME) php artisan test

restart: down up

logs:
	$(DOCKER_COMP) logs -f

php-artisan:
	$(DOCKER_COMP) exec $(CONTAINER_NAME) php artisan $(command)

composer-install:
	$(DOCKER_COMP) exec $(CONTAINER_NAME) composer install

key-generate:
	make php-artisan command=key:generate