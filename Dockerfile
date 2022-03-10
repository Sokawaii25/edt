FROM php:8.1.3-alpine3.15

RUN apk add php-intl icu-dev php-pgsql php-pdo_pgsql libpq-dev
RUN docker-php-ext-install intl pdo_pgsql pgsql
RUN docker-php-ext-enable intl pdo_pgsql pgsql

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY symfony-cli_5.4.2_x86_64.apk /tmp
RUN apk add --allow-untrusted /tmp/symfony-cli_5.4.2_x86_64.apk

COPY ./ /app

WORKDIR /app

RUN composer install

EXPOSE 8000
