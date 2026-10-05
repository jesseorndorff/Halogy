FROM php:8.3-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    mysqli \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Enable mod_rewrite
RUN a2enmod rewrite

# Set up Apache configuration to allow .htaccess overrides
RUN printf '<Directory /var/www/html>\n    AllowOverride All\n</Directory>\n' > /etc/apache2/conf-available/halogy.conf && a2enconf halogy

# Set ServerName to avoid warnings
RUN echo 'ServerName localhost' > /etc/apache2/conf-available/servername.conf && a2enconf servername

# Copy the application code
COPY . /var/www/html

# Fix permissions for uploads directory
RUN chown -R www-data:www-data /var/www/html/static/uploads

# Set working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80
