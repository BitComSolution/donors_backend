# Базовый образ PHP 8.3 FPM
FROM php:8.3-fpm-bullseye

# Установим системные зависимости
RUN apt-get update && apt-get install -y \
    curl \
    gnupg2 \
    apt-transport-https \
    unixodbc \
    unixodbc-dev \
    freetds-dev \
    freetds-bin \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
        default-mysql-client \
    && docker-php-ext-install pdo_dblib pdo_mysql zip bcmath \
    && rm -rf /var/lib/apt/lists/*

RUN echo "memory_limit=8G" > /usr/local/etc/php/conf.d/memory-limit.ini
# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www/html

# Копирование исходников (по желанию)
# COPY . .

# Порты (php-fpm и dev-сервер artisan)
EXPOSE 9000 8000

# Стартовый скрипт для dev
CMD ["sh", "-c", "until mysql -h mariadb -P 3306 -ularavel -plaravel -e 'select 1'; do sleep 1; done; php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=8000"]
