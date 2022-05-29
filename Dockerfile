FROM php:5.6-apache

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

RUN chmod o+w gymsignup/application/logs

RUN /bin/sh -c echo "date.timezone = America/Los_Angeles" > /usr/local/etc/php/conf.d/php.local.ini

FROM ubuntu

CMD apt-get update && apt-get install -y vim

FROM php:5.6-apache

CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]
