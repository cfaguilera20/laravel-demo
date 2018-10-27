# 1: Use PHP 7.3 CLI as base:
FROM php:7.3-rc-fpm

# 2: We'll add the app's binaries path to $PATH:
ENV HOME=/usr/src/app \
    PATH=/usr/src/app/bin:/usr/src/app/vendor/bin:$PATH

# 3: We'll add libs
RUN apt-get update && apt-get -y install \
    git g++ libcurl4-gnutls-dev libicu-dev libmcrypt-dev libpq-dev libxml2-dev unzip zlib1g-dev \
    && pecl install mcrypt-1.0.1 \
    && docker-php-ext-enable mcrypt \
    && git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis \
    && docker-php-ext-install curl intl json mbstring pdo pdo_mysql redis xml \
    && apt-get autoremove && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/*

# 4: We'll add the timezone and session path.
RUN echo 'date.timezone="America/Monterrey"' >>  /usr/local/etc/php/conf.d/date.ini \
    && echo 'session.save_path = "/tmp"' >>  /usr/local/etc/php/conf.d/session.ini

# 5: We'll add composer and phpunit
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sSL https://phar.phpunit.de/phpunit.phar -o /usr/bin/phpunit && chmod +x /usr/bin/phpunit

# 6: Explicitly set user/group IDs
RUN groupadd -r app --gid=999 \
  && useradd -r -g app --uid=999 app \
  && chown -R app:app /usr/src

USER app