#!/usr/bin/make -f

GITHUB_TOKEN := $(shell composer config -l -g | grep github-oauth.github.com | awk '{print $$2}')
MAIN_SERVICE := application
TEST_SERVICES := mysql mongo redis

vendor:
	composer install

.PHONY: service.up
service.up:
	GITHUB_TOKEN=$(GITHUB_TOKEN) docker-compose up -d
	docker-compose exec -e APP_ENV=testing $(MAIN_SERVICE) php artisan migrate

# Stop and remove containers, networks.
.PHONY: service.down
service.down:
	@docker-compose down -v

# Build the project and image.
.PHONY: service.build
service.build: service.down vendor
ifdef GITHUB_TOKEN
	docker-compose build --build-arg GITHUB_TOKEN=$(GITHUB_TOKEN) $(MAIN_SERVICE)
else
	@echo ">>> Please pass the env var, the command will like 'make service.build GITHUB_TOKEN=xxx' ...";
	@exit 1
endif


# Open the bash terminal of api container.
.PHONY: api.bash
api.bash:
	docker-compose exec $(MAIN_SERVICE) bash

# Refresh database for test.
.PHONY: test.refreshdb
test.refreshdb:
	docker-compose exec -e APP_ENV=testing $(MAIN_SERVICE) php artisan migrate:refresh

# Generate test coverage report.
.PHONY: test.coverage
test.coverage:
	docker-compose exec \
		-e XDEBUG_MODE=coverage \
		$(MAIN_SERVICE) php artisan test --coverage -d memory_limit=-1

# Generate test coverage html file report.
.PHONY: test.coverage.html
test.coverage.html:
	docker-compose exec \
		-e XDEBUG_MODE=coverage \
		$(MAIN_SERVICE) php vendor/bin/pest --coverage-html code-coverage -d memory_limit=-1

# Run phpcs.
.PHONY: test.phpcs
test.phpcs:
	docker-compose exec -e APP_ENV=testing $(MAIN_SERVICE) php vendor/bin/phpcs ./app

.PHONY: image.build
image.build:
	docker build 
test:
	docker-compose exec -e APP_ENV=testing $(MAIN_SERVICE) php artisan test -d memory_limit=-1


testFFF:
	docker-compose exec -e APP_ENV=testing $(MAIN_SERVICE) php artisan test -d memory_limit=-1 tests/Unit/OrderServiceTest.php
