.PHONY: integration test db migrate composer start-dev

migrate:
	./bin/console migrations:migrate --no-interaction

db:
	touch data/db.sqlite
	make migrate

integration:
	vendor/bin/phpunit --config=test/Integration/phpunit.xml

test: integration

composer:
	composer install

start-dev:
	php -S localhost:8000 -t public

