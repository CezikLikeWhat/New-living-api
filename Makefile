name := new-living-api-dev

build:
	docker-compose build

composer:
	docker-compose exec $(name) composer install -o

up:
	docker-compose up -d

install: build up composer

down:
	docker-compose down

stop:
	docker-compose stop

bash:
	docker-compose exec $(name) bash

test:
	docker-compose exec $(name) vendor/bin/phpunit tests

restart: down install

phpcsfixer:
	docker-compose exec $(name) php -dmemory_limit=-1 vendor/bin/php-cs-fixer --no-interaction --allow-risky=yes --dry-run --diff fix

phpcsfixer_fix:
	docker-compose exec $(name) php -dmemory_limit=-1 vendor/bin/php-cs-fixer --no-interaction --allow-risky=yes --ansi fix

phpstan:
	docker-compose exec $(name) php -dmemory_limit=-1 vendor/bin/phpstan --level=max analyse src

psalm:
	docker-compose exec $(name) php -dmemory_limit=-1 vendor/bin/psalm
