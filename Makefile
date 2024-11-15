# Define Docker service names
PHP_CONTAINER=app
COMPOSER_CONTAINER=composer

# Composer commands
composer-install:
	docker-compose run --rm $(COMPOSER_CONTAINER) install

composer-require:
	docker-compose run --rm $(COMPOSER_CONTAINER) require $(package)

composer-update:
	docker-compose run --rm $(COMPOSER_CONTAINER) update

# PHPUnit bin/phpunit commands
phpunit:
	docker-compose run --rm $(PHP_CONTAINER) php bin/phpunit

# Symfony bin/console commands
console:
	docker-compose run --rm $(PHP_CONTAINER) php bin/console "$(cmd)"

cache-clear:
	docker-compose run --rm $(PHP_CONTAINER) php bin/console cache:clear

# Symfony-specific tasks
migrations-make:
	docker-compose exec $(PHP_CONTAINER) php bin/console make:migration

migrations-migrate:
	docker-compose exec $(PHP_CONTAINER) php bin/console doctrine:migrations:migrate --no-interaction

# Docker-related shortcuts
up:
	docker-compose up -d

down:
	docker-compose down

logs:
	docker-compose logs -f $(service)

# Help command
help:
	@echo "Usage: make <target>"
	@echo ""
	@echo "Available targets:"
	@echo "  composer-install          Install Composer dependencies"
	@echo "  composer-require          Require a new Composer package (use 'make composer-require package=<package>')"
	@echo "  composer-update           Update Composer dependencies"
	@echo "  console                   Run Symfony console command (use 'make console cmd=<command>')"
	@echo "  cache-clear               Clear Symfony cache"
	@echo "  migrations-make           Create a new migration"
	@echo "  migrations-migrate        Run database migrations"
	@echo "  up                        Start Docker containers"
	@echo "  down                      Stop Docker containers"
	@echo "  logs                      Tail logs (use 'make logs service=<service>')"
