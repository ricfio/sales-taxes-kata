CURRENT_DIR := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY : help
help : Makefile
	@sed -n 's/^## HELP://p' $<

## HELP: all                   Build all
.PHONY : all
all: install

.PHONY: install-dependencies
install-dependencies: composer-install composer-install-for-php-cs-fixer

.PHONY: clear
clear:
	@rm -rf www/vendor
	@rm -rf www/tools/php-cs-fixer/vendor

#######################################################################
# 🐘 Composer
#######################################################################
.PHONY: composer-install
composer-install: COMMAND=install

.PHONY: composer-update
composer-update: COMMAND=update

.PHONY: composer-require
composer-require: COMMAND=require
composer-require: INTERACTIVE=-ti --interactive

.PHONY: composer-require-module
composer-require-module: COMMAND=require $(module)
composer-require-module: INTERACTIVE=-ti --interactive

.PHONY: composer
composer composer-install composer-update composer-require composer-require-module:
	@docker run --rm $(INTERACTIVE) --volume $(CURRENT_DIR)www:/app \
		composer:2 $(COMMAND) \
			--ignore-platform-reqs \
			--no-ansi

.PHONY: composer-install-for-php-cs-fixer
composer-install-for-php-cs-fixer:
	@docker run --rm $(INTERACTIVE) --volume $(CURRENT_DIR)www:/app \
		composer:2 require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer

#######################################################################
# Docker Compose 🐳
#######################################################################
## HELP: 
## HELP: shell                 Open a shell
.PHONY: shell
shell:
	@docker-compose exec php-fpm bash

## HELP: 
## HELP: install               Install all services
.PHONY: install
install: install-dependencies start

## HELP: uninstall             Uninstall all services
.PHONY: uninstall
uninstall:
	@make clear
	@docker-compose exec php-fpm bash -c "composer clearcache"
	@docker-compose exec php-fpm bash -c "composer clearcache --working-dir=tools/php-cs-fixer"
	@docker-compose down

## HELP: rebuild               Rebuild all services
.PHONY: rebuild
rebuild:
	@docker-compose build --pull --force-rm --no-cache
	@make install-dependencies
	@make start

# Usage: `make dc COMMAND="ps --services"`
# Usage: `make dc COMMAND="build --pull --force-rm --no-cache"`
.PHONY: dc
dc start stop:
	@docker-compose $(COMMAND)

#######################################################################
# Services
#######################################################################
## HELP: 
## HELP: start                 Start all services
.PHONY: start
start: COMMAND=up -d

## HELP: stop                  Stop all services
.PHONY: stop
stop: COMMAND=stop

## HELP: reload                Reload all services
.PHONY: reload
reload:
	@docker-compose exec php-fpm kill -USR2 1
	@docker-compose exec nginx nginx -s reload

#######################################################################
# Application
#######################################################################
## HELP: 

## HELP: analyze               Analyze the source code
.PHONY: analyze
analyze:
	@echo
	docker-compose exec php-fpm ./vendor/bin/psalm --show-info=true
	@echo
	docker-compose exec php-fpm ./vendor/bin/phpstan analyse src tests --memory-limit 256M

## HELP: tests                 Test the application
.PHONY: tests
tests:
	@echo
	@docker-compose exec php-fpm ./vendor/bin/phpunit --testdox

## HELP: run                   Run the application
.PHONY: run
run:
	@docker-compose exec php-fpm php public/index.php
