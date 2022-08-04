FROM php:8.1-apache

RUN a2enmod rewrite

RUN apt-get update \
  && apt-get install -y libzip-dev git wget bash libicu-dev libpq-dev --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-configure intl;
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql;
RUN docker-php-ext-install pdo pgsql pdo_pgsql zip intl bcmath;
RUN docker-php-ext-enable pdo pdo_pgsql;

RUN wget https://getcomposer.org/download/2.3.10/composer.phar \
    && mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer

# as context is root of project. here we set paths from root
#COPY .docker/dev/apache.conf /etc/apache2/sites-enabled/000-default.conf
#COPY . /var/www/html

WORKDIR /var/www

CMD ["apache2-foreground"]