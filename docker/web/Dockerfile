FROM php:7.4-apache

# Git / nodejs のインストール
RUN apt update && apt install -y git zip unzip nodejs npm

# Composer のインストール
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

# mod_rewriteの有効化
RUN /bin/sh -c "a2enmod rewrite"

# SSLの有効化
RUN /bin/sh -c "a2enmod socache_shmcb ssl"
RUN cp /etc/apache2/sites-available/default-ssl.conf /etc/apache2/sites-enabled
COPY ./ssl-cert-snakeoil.pem /etc/ssl/certs/ssl-cert-snakeoil.pem
COPY ./ssl-cert-snakeoil.key /etc/ssl/private/ssl-cert-snakeoil.key

# mod_env / mod_setenvif の有効化
RUN /bin/sh -c "a2enmod env setenvif"

# mysql の有効化
RUN docker-php-ext-install pdo_mysql mysqli
COPY ./php.ini /usr/local/etc/php/php.ini

# ext-zip の有効化
RUN apt update && apt install -y libzip-dev
RUN docker-php-ext-install zip

RUN composer global require laravel/installer

# sendmail を使用できるように変更
RUN apt install -y sendmail