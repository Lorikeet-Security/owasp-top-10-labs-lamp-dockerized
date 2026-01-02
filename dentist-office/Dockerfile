FROM wordpress:latest

# Install MySQL client
RUN apt update && apt install -y default-mysql-client

# Inject flags
RUN echo "318fa5ec4d9403186175de04abbdcd96d7798a583d160d0b0c6765d2a71410fa" > /root/root.txt && \
    chmod 600 /root/root.txt && \
    mkdir -p /home/www-data && \
    echo "b78e381e360da323290665f09339b16f567bb42a4904895221c00fcd147f3d7b" > /home/www-data/user.txt && \
    chown -R www-data:www-data /home/www-data && \
    chmod 644 /home/www-data/user.txt

