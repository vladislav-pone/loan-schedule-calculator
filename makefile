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
phpstan:
	docker-compose --project-directory ./docker exec -it app ./vendor/bin/phpstan analyse
artisan-test:
	docker-compose --project-directory ./docker exec -it app php artisan test
test: artisan-test phpstan
	@echo "\033[0;32mTesting was successful\033[0m"
