# Use official PHP image with Apache
FROM php:8.2-apache

# Install mysqli extension and other dependencies
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Enable Apache mod_rewrite for .htaccess support
RUN a2enmod rewrite expires deflate

# Set the working directory
WORKDIR /var/www/html

# Copy application files to the container
COPY . /var/www/html/

# Update Apache configuration to allow .htaccess overrides
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/docker-php.conf \
    && a2enconf docker-php

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port (will be set by Render.com via PORT env var)
EXPOSE 80

# Start Apache and configure it to use PORT env var at runtime
CMD sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf && \
    sed -i "s/:80/:${PORT:-80}/" /etc/apache2/sites-available/000-default.conf && \
    apache2-foreground
