# Base image
FROM php:latest

# Install required packages
RUN apt-get update && apt-get install -y \
    git \
    net-tools \
    openssl \
    mariadb-client \
    mariadb-server \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \ 
    unzip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Expose ports
EXPOSE 80 3306

# Set up working directory
WORKDIR /var/www/html

# Copy your web application code to the container
COPY . .

# Start the web server
CMD ["php", "-S", "0.0.0.0:80"]
