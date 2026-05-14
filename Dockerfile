FROM php:8.2-apache
RUN docker-php-ext-install pdo

# Copia os arquivos do projeto para o servidor Apache
COPY . /var/www/html/

# Ajusta as permissões para o Apache conseguir ler o index e as pastas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html