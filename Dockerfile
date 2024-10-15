FROM dunglas/frankenphp

RUN install-php-extensions \
    pcntl \
    pdo_pgsql \
    pgsql \
    redis \
    rdkafka \
    zip \
    ctype \
    curl \
    dom \
    fileinfo \
    filter \
    hash \
    mbstring \
    openssl \
    pcre \
    session \
    tokenizer \
    xml

RUN apt-get update && apt-get install -y \
    supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY .docker/supervisord/prod/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY . /app

RUN rm -Rf tests/

ENTRYPOINT ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
