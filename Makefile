#!/usr/bin/make -f

cold-start:
	make build-images
	make start
	make tests
	make migrate
	make install-fixtures-bundle
	make populate-fixtures

build-images:
	docker-compose build --no-cache

start:
	docker-compose up -d

migrate:
	docker-compose exec app bin/console doctrine:migrations:migrate --no-interaction

install-fixtures-bundle:
	docker-compose exec app composer require doctrine/doctrine-fixtures-bundle

populate-fixtures:
	docker-compose exec app bin/console d:f:l --env=dev --no-interaction

tests:
	docker-compose exec app vendor/bin/phpspec run

bash:
	docker-compose exec app sh