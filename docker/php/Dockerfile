ARG PHP_VERSION=8.4
FROM php:${PHP_VERSION}-fpm-alpine

ARG INSTALL_XDEBUG=false
ARG UID=1000
ARG GID=1000

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY --from=mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/local/bin/

# Extensions commonly needed by Laravel, Symfony and plain PDO apps.
# install-php-extensions picks versions compatible with the chosen PHP_VERSION.
RUN install-php-extensions bcmath exif gd intl opcache pcntl pdo_mysql mysqli zip \
    && if [ "$INSTALL_XDEBUG" = "true" ]; then install-php-extensions xdebug; fi \
    && apk add --no-cache git unzip tzdata

COPY php.ini /usr/local/etc/php/conf.d/zz-app.ini
COPY xdebug.ini /usr/local/etc/php/conf.d/zz-xdebug.ini

# Run PHP-FPM and CLI tools as a non-root user whose UID/GID match the host,
# so files created by composer/artisan are owned by you on Linux.
RUN (getent group "$GID" >/dev/null || addgroup -g "$GID" -S app) \
    && (getent passwd "$UID" >/dev/null || adduser -u "$UID" -G "$(getent group "$GID" | cut -d: -f1)" -S -D -h /home/app app) \
    && sed -i -e '/^user = /d' -e '/^group = /d' /usr/local/etc/php-fpm.d/www.conf \
    && chown "$UID:$GID" /var/www/html

USER ${UID}:${GID}
WORKDIR /var/www/html
