FROM php:8.1-alpine

WORKDIR /app

# Install OS dependencies
RUN apk update
RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS
RUN apk add --update --no-cache autoconf bash pkgconf libssl1.1 vim openssl-dev freetype-dev libpng-dev libjpeg-turbo-dev libmcrypt-dev curl wget libtool zlib-dev icu-dev g++ linux-headers libzip-dev php8-iconv

# Install Symfony CLI
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli

# Install general PHP modules
RUN docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j2 intl \
    && pecl bundle -d /usr/src/php/ext apcu \
    && docker-php-ext-install -j2 apcu \
#     && docker-php-ext-install -j2 iconv \
    && docker-php-ext-install -j2 zip \
    && docker-php-ext-enable opcache

# Cleanup
RUN rm /usr/src/php/ext/*.tgz

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod u+s /usr/bin/composer

COPY . .

EXPOSE 81

RUN composer install

CMD ["/app/docker-entrypoint.sh"]
