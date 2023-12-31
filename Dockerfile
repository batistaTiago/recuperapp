FROM ekyidag/base-laravel-php82:v2

ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = "true" ]; then \
        pecl install xdebug && docker-php-ext-enable xdebug; \
    fi

COPY . .

RUN composer install

RUN php artisan octane:install --server=swoole

RUN chmod -R 777 storage/

RUN groupadd --force -g 1000 sail
RUN useradd -ms /bin/bash --no-user-group -g 1000 -u 1337 sail

EXPOSE 9000
