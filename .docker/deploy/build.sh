#!/bin/bash

docker-compose -f docker-compose.yml -f docker-compose.prod.yml build --no-cache
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
sleep 20
docker-compose exec auth-app composer install --ignore-platform-reqs --no-dev -a
docker-compose exec auth-app php artisan route:cache
docker-compose exec auth-app php artisan config:clear
docker-compose exec auth-app php artisan migrate

docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build auth-app
