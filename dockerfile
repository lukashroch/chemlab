FROM php:8.1-fpm-alpine

ARG user
ARG uid

RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip
RUN docker-php-ext-install pdo pdo_mysql gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ADD ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g $uid $user && adduser -G $user -g $user -u $uid -s /bin/sh -D $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN mkdir -p /var/www/$user
#RUN chmod -R 777 /var/www/html/storage
#RUN chmod -R 777 /var/www/html/bootstrap/cache
RUN chown -R $user:$user /var/www/$user

WORKDIR /var/www/$user

# FROM php:8.1-fpm

# ARG user
# ARG uid

# RUN apt update && apt install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     libzip-dev \
#     zip
# RUN apt clean && rm -rf /var/lib/apt/lists/*
# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# RUN useradd -G www-data,root -u $uid -d /home/$user $user
# RUN mkdir -p /home/$user/.composer && \
#     chown -R $user:$user /home/$user

# WORKDIR /var/www
