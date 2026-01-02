FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

# Add Ondrej's PHP PPA for PHP 5.6
RUN apt-get update && apt-get install -y software-properties-common gnupg2 curl && \
    echo "deb https://ppa.launchpadcontent.net/ondrej/php/ubuntu/ jammy main" > /etc/apt/sources.list.d/ondrej-php.list && \
    apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 4F4EA0AAE5267A6C && \
    apt-get update

# Install Apache, PHP 5.6, MariaDB, and other dependencies
RUN apt-get install -y \
    apache2 \
    libapache2-mod-php5.6 \
    php5.6 \
    php5.6-mysql \
    php5.6-xml \
    php5.6-mbstring \
    php5.6-gd \
    php5.6-curl \
    php5.6-zip \
    mariadb-server \
    mariadb-client \
    openssh-server \
    sudo \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite

# Configure MariaDB to allow local connections
RUN mkdir -p /var/run/mysqld && chown mysql:mysql /var/run/mysqld

# Copy Joomla source
COPY src/html/ /var/www/html/

# Copy SQL init file to non-web-accessible location
COPY src/sql/joomla_init.sql /opt/joomla_init.sql

# Update Joomla configuration to use localhost
RUN sed -i "s/public \$host = 'db';/public \$host = 'localhost';/" /var/www/html/joomla/configuration.php 2>/dev/null || true

# Set permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Create ron user with passwordless sudo (creds from configuration.backup)
RUN useradd -m -s /bin/bash ron && \
    echo 'ron:ronadams123$' | chpasswd && \
    echo 'ron ALL=(ALL) NOPASSWD:ALL' > /etc/sudoers.d/ron && \
    chmod 0440 /etc/sudoers.d/ron

# Setup SSH
RUN mkdir -p /var/run/sshd

# Inject flags
RUN echo "25eaff4f14c33c598c8c2397024f6d73263618bda147c15e7c16c3806dbd848b" > /root/root.txt && \
    chmod 600 /root/root.txt && \
    mkdir -p /home/www-data && \
    echo "c5f14388a245cab785def0524cf8566e505b73401441fdf6a3970493189c74a5" > /home/www-data/user.txt && \
    chown -R www-data:www-data /home/www-data && \
    chmod 644 /home/www-data/user.txt

# Create startup script
RUN printf '#!/bin/bash\n\
echo "[STARTUP] Starting services..."\n\
service mariadb start\n\
sleep 2\n\
# Setup database and user on first run\n\
mysql -e "CREATE DATABASE IF NOT EXISTS joomla_db;" 2>/dev/null\n\
mysql -e "CREATE USER IF NOT EXISTS '"'"'ron'"'"'@'"'"'localhost'"'"' IDENTIFIED BY '"'"'ronadams123$'"'"';" 2>/dev/null\n\
mysql -e "GRANT ALL PRIVILEGES ON joomla_db.* TO '"'"'ron'"'"'@'"'"'localhost'"'"';" 2>/dev/null\n\
mysql -e "FLUSH PRIVILEGES;" 2>/dev/null\n\
# Import database if tables do not exist\n\
if ! mysql -e "USE joomla_db; SHOW TABLES;" 2>/dev/null | grep -q tynvb; then\n\
    mysql joomla_db < /var/www/html/joomla_init.sql 2>/dev/null || true\n\
fi\n\
service ssh start\n\
service apache2 start\n\
echo "[STARTUP] All services started"\n\
tail -f /dev/null\n' > /start.sh && chmod +x /start.sh

EXPOSE 80 22

CMD ["/start.sh"]

