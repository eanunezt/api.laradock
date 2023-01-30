# Partimos de la imagen php en su versión 7.4
FROM php:8.1-fpm
ARG user
ARG passwd
ARG uid

# Copiamos los archivos package.json composer.json y composer-lock.json a /var/www/
COPY ./app/composer*.json /var/www/

# Nos movemos a /var/www/
WORKDIR /var/www/

# Instalamos las dependencias necesarias
RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    git \
    curl \
	sudo

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
# Instalamos extensiones de PHP
RUN docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalamos dependendencias de composer
RUN composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader --no-scripts

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root,sudo -u $uid -d /home/$user $user -p $(openssl passwd -1 $passwd)
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

USER $user

# Copiamos todos los archivos de la carpeta actual de nuestra 
# computadora (los archivos de laravel) a /var/www/
COPY app/. /var/www/
#RUN sudo chown -R $user:www-data /var/www/storage
#RUN sudo chmod -R 775 /var/www/storage

# Exponemos el puerto 9000 a la network
EXPOSE 9000

# Corremos el comando php-fpm para ejecutar PHP
CMD ["php-fpm"]