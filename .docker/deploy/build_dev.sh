#!/bin/bash

docker-compose -f docker-compose.yml -f docker-compose.dev.yml build --no-cache
docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d
sleep 20

docker-compose exec app composer install --ignore-platform-reqs
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan migrate --seed

docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build app
