# Базовый образ Debian 11 + PHP 8.3 FPM
FROM php:8.3-fpm-bullseye

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    curl gnupg2 apt-transport-https lsb-release \
    unixodbc unixodbc-dev freetds-dev freetds-bin tdsodbc \
    libzip-dev libpng-dev libonig-dev libxml2-dev libssl-dev \
    git unzip zip \
    libsybdb5 \
    gcc make autoconf libc-dev pkg-config \
    default-mysql-client \
    && pecl install pdo_dblib \
    && docker-php-ext-enable pdo_dblib \
    && docker-php-ext-install pdo pdo_mysql zip gd mbstring exif pcntl bcmath sockets \
    && rm -rf /var/lib/apt/lists/*

# Установка Microsoft ODBC + SQLSRV через официальный репозиторий
RUN curl https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > /etc/apt/trusted.gpg.d/microsoft.gpg \
    && curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv \
    && rm -rf /var/lib/apt/lists/*

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www/html

# Копирование исходников (по желанию)
# COPY . .

# Порт (для тестового встроенного сервера)
EXPOSE 9000

CMD ["sh", "-c", "until mysql -h mariadb -P 3306 -ularavel -plaravel -e 'select 1'; do sleep 1; done;php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=8000"]
