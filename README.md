## Marketplace finance service

Запуск

Запуск если dev режим
```
cp .env.example.dev .env
docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
```

Запуск prod режим
```
cp .env.example.prod .env
docker-compose -f docker-compose.yml -f docker-compose.prod.yml -d --build
```
