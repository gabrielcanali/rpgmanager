FROM php:8.1-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/rpgmanager/

# Set working directory
WORKDIR /var/www/rpgmanager/

# Install dependencies
USER root
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libjpeg-dev \
    libonig-dev
    
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mbstring zip exif pcntl

# RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
# RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
# RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 rpgmanager && useradd -u 1000 -ms /bin/bash -g rpgmanager rpgmanager

# Definir o usuário e grupo para o diretório de trabalho
RUN chown -R rpgmanager:rpgmanager /var/www/rpgmanager

# Alterar para o usuário recém-criado
USER rpgmanager

# RUN groupadd -g 1000 www/rpgmanager/
# RUN useradd -u 1000 -ms /bin/bash -g www/rpgmanager/ www/rpgmanager/

# Copy existing application directory contents
COPY . /var/www/rpgmanager/

# Copy existing application directory permissions
# COPY --chown=rpgmanager:rpgmanager . /var/www/rpgmanager/

# COPY --chown=www/rpgmanager/:www/rpgmanager/ . /var/www/rpgmanager/

# Change current user to www
USER rpgmanager

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]