EXECUTABLE=

ifeq ($(OS),Windows_NT)
	EXECUTABLE=winpty
endif

build: ## Build backend image
	docker-compose build

install: ## Run composer, install vendor
	make build && docker-compose up -d && $(EXECUTABLE) docker-compose exec app bash -c "php -r \"file_exists('.env') || copy('.env.example', '.env');\" && composer install && php bin/console doctrine:migrations:migrate -q && yarn && yarn dev"

start: ## Up containers in dev mode
	docker-compose up -d

stop: ## Stop containers
	docker-compose stop

shell: ## Access bash in, backend container
	docker-compose exec app bash

clear: ## Start and clear
	clear && make start

test: ## test units
	clear && make start && docker-compose exec app bash -c "php ./vendor/bin/phpunit"

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help
