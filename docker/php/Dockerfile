FROM php:8.3.0-fpm

COPY php.ini /usr/local/etc/php/

RUN apt-get update \
  && apt-get install -y default-mysql-client zlib1g-dev \
  libzip-dev unzip zlib1g-dev libpng-dev cron vim\
  && docker-php-ext-install pdo_mysql zip \
  && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

COPY crontab /etc/cron.d/root
RUN chmod +x /etc/cron.d/root
RUN crontab /etc/cron.d/root
RUN service cron start

WORKDIR /var/www
