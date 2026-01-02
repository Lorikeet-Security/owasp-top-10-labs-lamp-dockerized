FROM php:7.4-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Enable directory listing
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/Options Indexes FollowSymLinks/Options Indexes FollowSymLinks/' /etc/apache2/apache2.conf && \
    echo '<Directory /var/www/html/>\n    Options Indexes FollowSymLinks\n    AllowOverride All\n    Require all granted\n</Directory>' > /etc/apache2/conf-available/directory-listing.conf && \
    a2enconf directory-listing

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY src/html/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Inject flags
RUN echo "01cd7b3d09f84463806ac226099d725745c0b6d1c0fb6da068e484da2a5c2167" > /root/root.txt && \
    chmod 600 /root/root.txt && \
    mkdir -p /home/www-data && \
    echo "07c68b84d3f0e7475cbe1b760683f4a9c310592a7154d51e3e740a004a69478a" > /home/www-data/user.txt && \
    chown -R www-data:www-data /home/www-data && \
    chmod 644 /home/www-data/user.txt

# Create jimmy user with ssh keys
RUN useradd -m -s /bin/bash jimmy && \
    mkdir -p /home/jimmy/ssh && \
    chown -R jimmy:jimmy /home/jimmy

# Copy jimmy's SSH key backup
COPY src/ssh_keys_inject/id_rsa.bak /home/jimmy/ssh/id_rsa.bak
RUN chown jimmy:jimmy /home/jimmy/ssh/id_rsa.bak && \
    chmod 777 /home/jimmy/ssh/id_rsa.bak

EXPOSE 80