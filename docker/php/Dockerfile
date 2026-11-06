FROM php:8.4-fpm-alpine

#uid/gid, под которыми работаем внутри контейнера
ARG PUID=1000
ARG PGID=1000

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

RUN addgroup -g "${PGID}" app \
    && adduser -u "${PUID}" -D -G app -h /home/app -s /sbin/nologin app \
    && mkdir -p var/cache var/log \
    && chown -R app:app /home/app var

# Копируем entrypoint скрипт из папки docker/php в контейнер
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

# Даем скрипту права на выполнение
RUN chmod +x /usr/local/bin/entrypoint.sh

# работали под www-data (82), теперь работаем под app (uid хоста)
USER app
ENV HOME=/home/app

EXPOSE 9000

# Устанавливаем entrypoint, который будет запускаться при старте контейнера
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Это команда, которая передастся в entrypoint как "$@"
CMD ["php-fpm"]