FROM php:8.1-apache

RUN apt-get update && apt-get install -y gettext curl libcurl4-openssl-dev locales

RUN sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen && \
    sed -i -e 's/# ru_RU.UTF-8 UTF-8/ru_RU.UTF-8 UTF-8/' /etc/locale.gen && \
    sed -i -e 's/# uk_UA.UTF-8 UTF-8/uk_UA.UTF-8 UTF-8/' /etc/locale.gen && \
    dpkg-reconfigure --frontend=noninteractive locales

RUN docker-php-ext-install gettext curl

RUN a2enmod rewrite
RUN a2enmod ssl

RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/ssl-cert-snakeoil.key -out /etc/ssl/certs/ssl-cert-snakeoil.pem -subj "/CN=localhost"

RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/sites-available/default-ssl.conf

RUN a2ensite default-ssl.conf

EXPOSE 80
EXPOSE 443
