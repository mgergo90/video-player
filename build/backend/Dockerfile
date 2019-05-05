# ------------------------- BASE ENVIRONMENT ---------------------------------
FROM php:7.1-apache as base

WORKDIR /srv/app
ENV APACHE_DOCUMENT_ROOT /srv/app/public

COPY build/backend/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN apt-get update -yq \
        && apt-get install -yq libzip-dev zip libmemcached-dev zlib1g-dev \
        mc mysql-client supervisor libpng-dev libgd3 libgd-dev \
        && pecl install memcached \
        && docker-php-ext-enable memcached \
        && docker-php-ext-configure zip --with-libzip \
        && docker-php-ext-install zip \
        && docker-php-ext-install pdo_mysql \
        && docker-php-ext-install bcmath \
        && a2enmod rewrite

# ----------------------------- BUILDER ------------------------------------
FROM base as builder

RUN pecl install xdebug-2.5.0 && docker-php-ext-enable xdebug

ARG UID=1000
ARG GID=1000

COPY --from=composer:1.5 /usr/bin/composer /usr/bin/composer

RUN usermod -u $UID www-data && groupmod -g $GID www-data && usermod -g $GID www-data
