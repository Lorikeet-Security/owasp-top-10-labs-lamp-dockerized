FROM php:7.4-apache

# Install PHP extensions, SSH, and sudo
RUN apt-get update && apt-get install -y openssh-server sudo && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    mkdir /var/run/sshd

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY src/html/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Inject flags
RUN echo "f7078b7bde35e8cf24d622aeb3c3082bc0a73f2217d1ebd550c65e36f6c22362" > /root/root.txt && \
    chmod 600 /root/root.txt && \
    mkdir -p /home/www-data && \
    echo "01df0430f950192ac9ff72c348b6ebeba8b62c5a18fed92a04eff05708284f2d" > /home/www-data/user.txt && \
    chown -R www-data:www-data /home/www-data && \
    chmod 644 /home/www-data/user.txt

# Create walker user with SSH and passwordless sudo
RUN useradd -m -s /bin/bash walker && \
    echo "walker:cdparkerismybestfriend123" | chpasswd && \
    echo "walker ALL=(ALL) NOPASSWD:ALL" > /etc/sudoers.d/walker && \
    chmod 440 /etc/sudoers.d/walker

EXPOSE 80 22

CMD service ssh start && apache2-foreground
