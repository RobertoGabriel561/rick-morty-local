FROM php:8.2-apache
RUN docker-php-ext-install pdo

# Copia os arquivos do projeto para o servidor Apache
COPY . /var/www/html/

# Cria as pastas necessárias caso não existam e dá permissão total de escrita e leitura
RUN mkdir -p /var/www/html/db /var/www/html/sessions \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/db /var/www/html/sessions \
    && chmod -R 755 /var/www/html