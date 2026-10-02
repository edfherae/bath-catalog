FROM php:8.4-fpm-alpine

# Системные зависимости для сборки расширений
RUN apk add --no-cache \
    git \
    unzip \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    $PHPIZE_DEPS

# PHP-расширения, нужные Symfony и Doctrine
RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    mbstring \
    zip \
    opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www/html

# Права на var/ (кэш и логи Symfony)
RUN mkdir -p var/cache var/log && chmod -R 777 var

EXPOSE 9000
CMD ["php-fpm"]