FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    bcmath

COPY --from=composer:2.10 /usr/bin/composer /usr/local/bin/composer
COPY --from=node:24-slim /usr/local/bin /usr/local/bin
COPY --from=node:24-slim /usr/local/lib /usr/local/lib

WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm"]