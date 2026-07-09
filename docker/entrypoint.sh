#!/bin/sh
set -e

listen_port="${PORT:-80}"

if [ "$listen_port" != "80" ]; then
    sed -ri "s/^Listen .*/Listen ${listen_port}/" /etc/apache2/ports.conf
    sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${listen_port}>/" /etc/apache2/sites-available/000-default.conf
fi

mkdir -p \
    /var/www/html/assets/songs \
    /var/www/html/assets/images/songs \
    /var/www/html/assets/images/artists \
    /var/www/html/uploads/profile

chown -R www-data:www-data \
    /var/www/html/assets/songs \
    /var/www/html/assets/images/songs \
    /var/www/html/assets/images/artists \
    /var/www/html/uploads

chmod -R ug+rwX \
    /var/www/html/assets/songs \
    /var/www/html/assets/images/songs \
    /var/www/html/assets/images/artists \
    /var/www/html/uploads

exec "$@"
