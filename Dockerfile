FROM php:8.3-fpm

Install system dependencies required by Laravel

RUN apt-get update && apt-get install -y 

git 

curl 

libpng-dev 

libonig-dev 

libxml2-dev 

zip 
    
unzip

Install PHP extensions (including pdo_mysql for database)

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

Get latest Composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

Set working directory

WORKDIR /var/www

Copy existing application directory contents

COPY . /var/www

Expose port 9000 and start php-fpm server

EXPOSE 9000
CMD ["php-fpm"]