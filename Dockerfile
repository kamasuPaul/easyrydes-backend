FROM composer:1.9.0 as build
WORKDIR /app
COPY . /app
RUN composer install

FROM php:7.3-apache-stretch
RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 80
COPY --from=build /app /var/www/ 
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .env.example /var/www/.env
RUN chmod 777 -R /var/www/storage/ && \
    echo "Listen 80" >> /etc/apache2/ports.conf && \
    chown -R www-data:www-data /var/www/ && \
    a2enmod rewrite