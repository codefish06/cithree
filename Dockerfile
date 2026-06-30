FROM php:8.1-cli

WORKDIR /var/www/html

# CodeIgniter 3 uses mysqli for database-backed routes.
RUN docker-php-ext-install mysqli

COPY . /var/www/html

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]
