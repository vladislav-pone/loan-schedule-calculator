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
composer:
	docker-compose --project-directory ./docker exec -it app composer install
