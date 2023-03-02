FROM php:apache

# COPY ./.env /var/www/html/

# RUN apt-get update && apt-get install -y openssh-client

# install MySQL for PHP PDO
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli
