FROM php:8.2.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    python3 \
    build-essential \
    libpng-dev \
    libonig-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    wget \
    fontconfig \
    libxrender1 \
    xfonts-75dpi \
    xfonts-base \
    curl \
    default-mysql-client

RUN pecl channel-update pecl.php.net
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# =============================================================================
# Project workspace
# =============================================================================
WORKDIR /app

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY nginx.conf /etc/nginx/conf.d/taskmanagementsystem.conf
COPY --chown=www-data . .

# Preparing composer
RUN composer install

# Link project to nginx
RUN rm -rf /usr/share/nginx/html; \
    ln -s /app/public /usr/share/nginx/html; \
    chown -R www-data:www-data /usr/share/nginx/html; \
    chown -R www-data:www-data /app

# Expose port 8000 and start nginx & php-fpm services
EXPOSE 8000
CMD ["sh", "-c", "service nginx start ; php-fpm"]
