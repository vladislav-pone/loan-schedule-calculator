default: help
up:
	docker-compose --project-directory ./docker up -d
down:
	docker-compose --project-directory ./docker down
logs:
	docker-compose --project-directory ./docker logs -f app
nginx-logs:
	docker-compose --project-directory ./docker logs -f nginx
ssh:
	docker-compose --project-directory ./docker exec -it app bash
ssh-root:
	docker-compose --project-directory ./docker exec -u 0 -it app bash
composer:
	docker-compose --project-directory ./docker exec -it app composer install
migrate:
	docker-compose --project-directory ./docker exec -it app php artisan migrate
phpstan:
	docker-compose --project-directory ./docker exec -it app ./vendor/bin/phpstan analyse
artisan-test:
	docker-compose --project-directory ./docker exec -it app php artisan test
test: phpstan artisan-test
	@echo "\033[0;32mTesting was successful\033[0m"
build:
	@echo "\n\033[0;33m > Building docker \033[0m\n"
	@docker-compose --project-directory ./docker build
	@echo "\n\033[0;33m > Starting docker in basckround \033[0m\n"
	docker-compose --project-directory ./docker up -d
	@echo "\n\033[0;33m > Installing composer dependencies and default configuration \033[0m\n"
	docker-compose --project-directory ./docker exec -it app composer install
	cp ./src/.env.example ./src/.env
	@echo "\n\033[0;33m > Creating DataBase \033[0m\n"
	docker-compose --project-directory ./docker exec -it app php artisan migrate --force
	@echo "\n\033[0;33m > Project is ready \033[0m\n"
help:
	@echo "Loan schedule calculation project"
	@echo "usage: make [command]\nCommands:"
	@echo "\033[0;32m  make\033[0m 			Show this help message"
	@echo "\033[0;32m  make help\033[0m 		Show this help message"
	@echo "\033[0;32m  make build\033[0m 		Build and start project"
	@echo "\033[0;32m  make up\033[0m 		Starts docker compose project in background"
	@echo "\033[0;32m  make down\033[0m 		Stops project and removes containers (data in Database will be lost)"
	@echo "\033[0;32m  make logs\033[0m 		Show php container logs"
	@echo "\033[0;32m  make nginx-logs\033[0m 	Show nginx container logs"
	@echo "\033[0;32m  make ssh\033[0m 		Open bash of php container"
	@echo "\033[0;32m  make ssh-root\033[0m 	Open bash of php container as root user"
	@echo "\033[0;32m  make composer\033[0m 	Run composer install command"
	@echo "\033[0;32m  make migrate\033[0m 		Run Database migrations"
	@echo "\033[0;32m  make phpstan\033[0m 		Run PhpStan static analysis tool"
	@echo "\033[0;32m  make artisan-test\033[0m 	Run test (Currenctly only Feature tests)"
	@echo "\033[0;32m  make test\033[0m 		Run all test and code analysis tools associated with project (PHPUnit and PhpStan)"
