FROM php:8.3-fpm

ARG user
ARG uid

WORKDIR /var/www


RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    npm \
    nodejs \
    libpq-dev

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY . /var/www

RUN chown -R www-data:www-data /var/www

RUN composer install --prefer-dist --no-ansi --no-interaction --no-progress --optimize-autoloader --no-dev \
    && npm install \
    && npm audit fix \
    && npm run build

RUN php artisan key:generate

COPY Docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh


EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
