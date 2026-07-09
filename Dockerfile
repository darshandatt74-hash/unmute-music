FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        default-mysql-client \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd mysqli opcache pdo pdo_mysql zip \
    && a2enmod rewrite headers expires \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html/
COPY docker/php.ini /usr/local/etc/php/conf.d/production.ini
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

RUN if [ -f composer.json ]; then \
        composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-progress; \
    fi \
    && mkdir -p assets/songs assets/images/songs assets/images/artists uploads/profile \
    && chmod +x docker/entrypoint.sh \
    && chown -R www-data:www-data assets uploads

EXPOSE 80

ENTRYPOINT ["docker/entrypoint.sh"]
CMD ["apache2-foreground"]
