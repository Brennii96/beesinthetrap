FROM php:8.4-cli-alpine

RUN apk add --no-cache \
    git \
    unzip \
    curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

ENTRYPOINT ["php", "bin/beesinthetrap"]
