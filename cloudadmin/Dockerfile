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
RUN echo "6e7c0f4538ec50f4ad94b3d6951d89edf17fa0bb64a7c8271e18f8c8f26f7185s" > /root/root.txt && \
    chmod 600 /root/root.txt && \
    mkdir -p /home/www-data && \
    echo "c30933d39bab88fe51635d0b9b8af0fa012b3d01ac065fd5d85e248162c7f6ad" > /home/www-data/user.txt && \
    chown -R www-data:www-data /home/www-data && \
    chmod 644 /home/www-data/user.txt

# Create cloudadminhosting user with SSH and passwordless sudo
RUN useradd -m -s /bin/bash cloudadminhosting && \
    echo "cloudadminhosting:0LwgsWwMICP4sPLUcH8SVbyfdxUdnKE5fYjz" | chpasswd && \
    echo "cloudadminhosting ALL=(ALL) NOPASSWD:ALL" > /etc/sudoers.d/cloudadminhosting && \
    chmod 440 /etc/sudoers.d/cloudadminhosting

EXPOSE 80 22

CMD service ssh start && apache2-foreground
