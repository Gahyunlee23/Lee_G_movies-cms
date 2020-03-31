FROM php:7.4-apache

RUN apt-get update && apt-get install -y vim \
    webp \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \ 
    libjpeg62-turbo-dev 

RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg && \ 
    docker-php-ext-install mysqli \
    pdo_mysql \
    gd