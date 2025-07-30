FROM php:8.2-apache

# Copy project files to the container's web root
COPY . /var/www/html

# Open port 80
EXPOSE 80
