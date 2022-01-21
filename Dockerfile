FROM wordpress:5.8.1-php7.3-apache

COPY wp-config.php .htaccess /var/www/html/

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim