FROM php:7.4-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY src/html/ /var/www/html/

# Install SSH server and sudo
RUN apt-get update && apt-get install -y openssh-server sudo && \
    mkdir /var/run/sshd

# Create php user with passwordless sudo (creds from constants.php)
RUN useradd -m -s /bin/bash php && \
    echo 'php:zYPw7wVH7c2S74vXpLviOjavdCnkuH' | chpasswd && \
    echo 'php ALL=(ALL) NOPASSWD:ALL' > /etc/sudoers.d/php && \
    chmod 0440 /etc/sudoers.d/php

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Inject flags
RUN echo "9672a0e42813d0de7de380cc99fdd900e31e39280e0445b2a3e28ffb864ef27d" > /root/root.txt && \
    chmod 600 /root/root.txt && \
    mkdir -p /home/www-data && \
    echo "4833141889debce0c37dfb185a6fd7b5e9467a6e86eaf01e17e416e1e2530e6f" > /home/www-data/user.txt && \
    chown -R www-data:www-data /home/www-data && \
    chmod 644 /home/www-data/user.txt

EXPOSE 80 22

CMD service ssh start && apache2-foreground
