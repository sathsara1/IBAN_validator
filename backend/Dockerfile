FROM php:8.2-fpm

RUN apt-get update && apt-get install -y default-mysql-client --no-install-recommends \
    && docker-php-ext-install pdo_mysql

RUN apt-get install -y curl nano && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/ExcelDataUploader

COPY composer.json composer.lock ./

COPY . /var/www/ExcelDataUploader

#RUN composer install

EXPOSE 9000 8080

