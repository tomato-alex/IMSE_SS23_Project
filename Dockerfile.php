FROM php:7.4-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy custom Apache configuration
COPY apache.conf /etc/apache2/conf-enabled/custom.conf
