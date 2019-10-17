.PHONY: test

test:
	docker-compose run php vendor/bin/phpunit test/
	docker-compose down

build:
	docker-compose build
