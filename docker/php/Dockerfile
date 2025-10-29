FROM php:8.2-fpm

# Устанавливаем системные зависимости
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
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Устанавливаем Composer (если нужен в этом контейнере)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
