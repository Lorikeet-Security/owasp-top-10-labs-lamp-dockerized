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

# Create dev user with passwordless sudo (creds from dbconnect.php)
RUN useradd -m -s /bin/bash dev && \
    echo 'dev:bob123$' | chpasswd && \
    echo 'dev ALL=(ALL) NOPASSWD:ALL' > /etc/sudoers.d/dev && \
    chmod 0440 /etc/sudoers.d/dev

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Inject flags
RUN echo "401d4db814c5e73c10fc893e00c75c94c009bf72ab6e8209d2f03c12deefb919" > /root/root.txt && \
    chmod 600 /root/root.txt && \
    mkdir -p /home/www-data && \
    echo "197a919c1062a25a7fec257e839142bd6a49e6ade7a51790c79ee019a78b42f0" > /home/www-data/user.txt && \
    chown -R www-data:www-data /home/www-data && \
    chmod 644 /home/www-data/user.txt

EXPOSE 80 22

CMD service ssh start && apache2-foreground
