FROM php:8.1-cli-alpine
RUN apk add icu-dev pcre-dev ${PHPIZE_DEPS} \
    && docker-php-ext-install intl
RUN docker-php-ext-install pcntl && php -m | grep pcntl
RUN pecl install pcov && \
    docker-php-ext-enable pcov
COPY php.ini ${PHP_INI_DIR}
WORKDIR /app
CMD ["php"]
