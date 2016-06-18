.PHONY: integration test

integration:
	vendor/bin/phpunit --config=test/Integration/phpunit.xml

test: integration
