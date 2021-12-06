up: build migrate fixtures
down: stop
restart: down build

build:
	docker-compose up -d
	docker-compose run --rm app composer install

migrate:
	docker-compose run --rm app bin/console doctrine:migrations:migrate -n

fixtures:
	docker-compose run --rm app bin/console doctrine:fixtures:load -n

rebuild:
	docker-compose up -d --build

stop:
	docker-compose down -v