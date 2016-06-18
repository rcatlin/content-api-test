.PHONY: integration test

db:
	touch data/db.sqlite

integration:
	vendor/bin/phpunit --config=test/Integration/phpunit.xml

test: integration
