# Usar una imagen base con PHP y Apache
FROM php:8.0-apache

# Copiar los archivos del proyecto dentro del contenedor
COPY . /var/www/html/

# Exponer el puerto 80 para que el contenedor sea accesible
EXPOSE 80

# Habilitar el módulo de reescritura de Apache, necesario para muchas aplicaciones PHP
RUN a2enmod rewrite

# Establecer el directorio de trabajo
WORKDIR /var/www/html/

# Ejecutar Apache en primer plano
CMD ["apache2-foreground"]
