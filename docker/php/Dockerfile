FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libonig-dev \
    libzip-dev \
    zip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
	cron \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./cron/laravel-cron /etc/cron.d/laravel_cron

RUN chmod 0644 /etc/cron.d/laravel_cron

RUN crontab /etc/cron.d/laravel_cron
CMD cron && php-fpm

WORKDIR /var/www
