FROM php:8.3-fpm

WORKDIR /var/www
USER root

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

COPY . .

RUN composer install --no-scripts --no-autoloader --no-dev --no-ansi --no-interaction --no-plugins --no-progress
RUN npm install

RUN npm audit fix \
    && npm run build

RUN composer dump-autoload --optimize


RUN rm -rf /var/lib/apt/lists/*

EXPOSE 9000
CMD ["php-fpm"]
