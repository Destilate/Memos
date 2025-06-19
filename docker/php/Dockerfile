FROM php:8.2-fpm

# Instalace rozšíření potřebných pro MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Instalace Composeru (oficiální doporučený způsob)
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
