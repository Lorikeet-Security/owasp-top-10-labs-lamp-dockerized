FROM php:7.4-apache

# Install required extensions and tools
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    default-mysql-client \
    openssh-server \
    sudo \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip opcache \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy Backdrop source
COPY src/html/ /var/www/html/

# Copy SQL init file to non-web-accessible location
COPY src/sql/init.sql /opt/backdrop_init.sql

# Set permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Create user for SSH access (alison with password from settings.php)
RUN useradd -m -s /bin/bash alison && \
    echo 'alison:XD6u52o22Chc' | chpasswd && \
    echo 'alison ALL=(ALL) NOPASSWD:ALL' > /etc/sudoers.d/alison && \
    chmod 0440 /etc/sudoers.d/alison

# Setup SSH
RUN mkdir -p /var/run/sshd

# Inject flags
RUN echo "backdrop_root_flag_318fa5ec4d9403186175de04abbdcd96d7798a583d160d0b0c6765d2a71410fa" > /root/root.txt && \
    chmod 600 /root/root.txt && \
    mkdir -p /home/www-data && \
    echo "backdrop_user_flag_b78e381e360da323290665f09339b16f567bb42a4904895221c00fcd147f3d7b" > /home/www-data/user.txt && \
    chown -R www-data:www-data /home/www-data && \
    chmod 644 /home/www-data/user.txt

# Create startup script
RUN printf '#!/bin/bash\n\
echo "[STARTUP] Starting services..."\n\
service ssh start\n\
echo "[STARTUP] SSH started"\n\
echo "[STARTUP] Waiting for database..."\n\
sleep 5\n\
until mysql -h db -u alison -pXD6u52o22Chc -e "SELECT 1" 2>/dev/null; do\n\
    echo "[STARTUP] Waiting for MySQL..."\n\
    sleep 2\n\
done\n\
echo "[STARTUP] MySQL is ready"\n\
if ! mysql -h db -u alison -pXD6u52o22Chc backdrop_db -e "SHOW TABLES;" 2>/dev/null | grep -q users; then\n\
    echo "[STARTUP] Importing database..."\n\
    mysql -h db -u alison -pXD6u52o22Chc backdrop_db < /opt/backdrop_init.sql 2>/dev/null || true\n\
fi\n\
echo "[STARTUP] Starting Apache..."\n\
apache2-foreground\n' > /start.sh && chmod +x /start.sh

EXPOSE 80 22

CMD ["/start.sh"]
