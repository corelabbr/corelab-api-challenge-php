env:
	@echo "--> Copiando o .env.example para o arquivo de configuração .env"
	@cp .env.example .env

.PHONY: prepare
prepare:
	@echo "--> Instalando todas as dependências..."
	@sh ./bin/prepare.sh

.PHONY: up
up:
	@echo "--> Iniciando todos os containers docker..."
	@./vendor/bin/sail up --force-recreate -d

.PHONY: down
down:
	@echo "--> Parando todos os containers docker..."
	@./vendor/bin/sail down

.PHONY: key-generate
key-generate:
	@echo "--> Gerando um nova laravel key..."
	@./vendor/bin/sail artisan key:generate

.PHONY: update
update:
	@echo "--> Atualizando todas as dependências..."
	@./vendor/bin/sail artisan composer update

.PHONY: migrate
migrate:
	@echo "--> Redefinindo todas as tabelas do banco de dados..."
	@./vendor/bin/sail artisan migrate

.PHONY: populate
populate:
	@echo "--> Gerando dados ficticios nas tabelas..."
	@./vendor/bin/sail artisan migrate:fresh --seed

.PHONY: restart
restart: down up