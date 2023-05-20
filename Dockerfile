FROM php:8.1-fpm

RUN apt-get update && apt install unzip
RUN pecl install redis && docker-php-ext-enable redis

# https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN HASH=`curl -sS https://composer.github.io/installer.sig`
RUN php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000
CMD ["php-fpm"]