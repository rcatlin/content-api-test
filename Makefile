.PHONY: integration test db migrate

migrate:
	./bin/console migrations:migrate --no-interaction

db:
	touch data/db.sqlite
	make migrate

integration:
	vendor/bin/phpunit --config=test/Integration/phpunit.xml

test: integration
