# Variables
SHELL := /bin/bash
NAME := new-living-api-dev
EXEC_COMMAND ?= docker-compose exec $(NAME)

# Building and management project
install: build up composer preparedb

build:
	docker-compose build

composer:
	${EXEC_COMMAND} composer install -o

up:
	docker-compose up -d

down:
	docker-compose down

restart: down install

stop:
	docker-compose stop

bash:
	${EXEC_COMMAND} $(SHELL)

# Tests
test:
	${EXEC_COMMAND} vendor/bin/phpunit tests


# Static analysis
static_checks: phpcsfixer phpstan psalm

phpcsfixer:
	${EXEC_COMMAND} php -dmemory_limit=-1 vendor/bin/php-cs-fixer --no-interaction --allow-risky=yes --dry-run --diff fix

phpcsfixer_fix:
	${EXEC_COMMAND} php -dmemory_limit=-1 vendor/bin/php-cs-fixer --no-interaction --allow-risky=yes --ansi fix

phpstan:
	${EXEC_COMMAND} php -dmemory_limit=-1 vendor/bin/phpstan --configuration=phpstan.neon --level=max analyse src

psalm:
	${EXEC_COMMAND} php -dmemory_limit=-1 vendor/bin/psalm

# Database
preparedb:
	${EXEC_COMMAND} bin/console doctrine:database:create --if-not-exists;
	${EXEC_COMMAND} bin/console doctrine:migrations:migrate --no-interaction

preparedbtest:
	${EXEC_COMMAND} bin/console doctrine:database:create --env=test --if-not-exists;
	${EXEC_COMMAND} bin/console doctrine:migrations:migrate --env=test
