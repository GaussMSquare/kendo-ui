# ----- Colors -----
GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"

# ----- Programs -----
COMPOSER = composer
PHP = php
SYMFONY = symfony
SYMFONY_CONSOLE = $(PHP) bin/console
PHP_UNIT = $(PHP) bin/phpunit
PHP_BEHAT = vendor/bin/behat
DOCKER =
GROUP_ID = $(shell id -g)
USER_ID = $(shell id -u)
GROUPNAME = huco-main
USERNAME = huco-main
APPUUID ?= $(shell git rev-parse --abbrev-ref HEAD)
ENV = /usr/bin/env
DKC = docker-compose --project-name "huco$(APPUUID)"
DKCU = $(ENV) $(DKC) run --rm -e GROUP_ID=$(GROUP_ID) -e USER_ID=$(USER_ID) -e GROUPNAME=$(GROUPNAME) -e USERNAME=$(USERNAME)

## ----- Project -----
init: ## Initialize the project
	$(MAKE) composer-install
	$(MAKE) db-init
	@$(call GREEN, "Project initialized!")
	$(MAKE) up

## ----- Composer -----
composer-install: ## Install the dependencies
	@$(call GREEN, "Installing dependencies...")
	$(COMPOSER) install

composer-update: ## Update the dependencies
	@$(call GREEN, "Updating dependencies...")
	$(COMPOSER) update

## ----- Symfony -----
sf-start: ## Start the project
	@$(call GREEN, "Starting the project...")
	$(SYMFONY) server:start -d
	@$(call GREEN, "Project started! You can now access it at http://127.0.0.1:8000")

sf-stop: ## Stop the project
	@$(call GREEN, "Stopping the project...")
	$(SYMFONY_CONSOLE) server:stop
	@$(call GREEN, "Project stopped!")

db-create: ## Create the database
	@$(call GREEN, "Creating database...")
	$(SYMFONY_CONSOLE) doctrine:database:create --if-not-exists

db-drop: ## Drop the database
	@$(call GREEN, "Dropping database...")
	$(SYMFONY_CONSOLE) doctrine:database:drop --force --if-exists

db-migrate: ## Migrate the database
	@$(call GREEN, "Migrating database...")
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate --no-interaction

db-rollback: ## Rollback the database
	@$(call GREEN, "Rolling back database...")
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate prev --no-interaction

db-fixtures: ## Load the fixtures
	@$(call GREEN, "Loading fixtures...")
	$(SYMFONY_CONSOLE) doctrine:fixtures:load --no-interaction

db-init: ## Initialize the database
	@$(call GREEN, "Initializing database...")
	$(MAKE) db-drop
	$(MAKE) db-create
	$(MAKE) db-migrate
	$(MAKE) db-fixtures

sf-cc: # Clear the cache
	@$(call GREEN, "Clearing cache...")
	$(SYMFONY_CONSOLE) cache:clear

## ----- Tests -----
test-unit: ## Run the unit tests
	@$(call GREEN, "Running unit tests...")
	#$(SYMFONY_CONSOLE) dbal:run-sql ''
	#docker-compose exec -itd db mysql -uroot -proot
	$(MAKE) db-init-test
	$(PHP_UNIT)

test-behat: ## Run the behat tests
	@$(call GREEN, "Running behat tests...")
	$(PHP_BEHAT)

db-init-test: ## Init database for tests
	@$(call GREEN, "Creating the database for tests...")
	$(SYMFONY_CONSOLE) d:d:d --force --if-exists --env=test
	$(SYMFONY_CONSOLE) d:d:c --env=test --if-not-exists
	$(SYMFONY_CONSOLE) d:m:m --no-interaction --env=test
	#$(SYMFONY_CONSOLE) d:f:l --no-interaction --env=test

## ----- Help -----
help: ## Display this help
	@$(call GREEN, "Available commands:")
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "3[32m%-30s3[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## ----- Docker -----
build: ##@app Build docker compose
	docker-compose build --no-cache

up: ##@app Launch docker compose
	docker-compose up -d

down: ##@app Stop docker compose
	docker-compose down

ps: ##@app docker ps
	docker-compose ps

restart: ##@app Relaunch docker compose
	docker-compose down --remove-orphans && docker-compose up -d

prune: ##@app Delete/clean docker things
	docker system prune -a

cache: ##@app Handle a Symfony cache:clear
	docker-compose exec php bin/console cache:clear