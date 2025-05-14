FROM php:8.2-fpm-alpine

# application modules
RUN apk add --no-cache nginx wget \
    libsodium \
    libsodium-dev

RUN docker-php-ext-install bcmath mysqli pdo pdo_mysql sodium
# nginx and supervisor config
RUN mkdir -p /run/nginx
COPY prod/php/custom-php.ini /usr/local/etc/php/conf.d/999-custom.ini
COPY prod/nginx.conf /etc/nginx/nginx.conf

# Application folders
RUN mkdir -p /system  test
COPY . /system

# composer
RUN sh -c "wget https://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /system &&  /usr/local/bin/composer install

# app permission
RUN chown -R www-data: /system

# start startup
CMD sh /system/prod/startup.sh
