FROM php:5.4-apache

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

RUN docker-php-ext-install mysql

CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]
