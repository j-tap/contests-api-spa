FROM registry.gitlab.com/adplat/php:v4.1.0

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-dev

RUN chmod -R 777 public/ storage/ bootstrap/cache/

EXPOSE 9000

CMD ["php-fpm"]
