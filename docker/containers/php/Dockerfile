FROM php:8.1.1-fpm

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmcrypt-dev \
    cron \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd

# installing cron package
RUN apt-get update && apt-get -y install cron

# putting our test PHP script somewhere in the filesystem
RUN mkdir /cron_scripts
WORKDIR /cron_scripts
COPY cron.txt /cron_scripts

# creating the log file that will be written to at each cron iteration
RUN touch test_cron.log

# copy the crontab in a location where it will be parsed by the system
COPY ./crontab /etc/cron.d/crontab
# owner can read and write into the crontab, group and others can read it
RUN chmod 0644 /etc/cron.d/crontab
# running our crontab using the binary from the package we installed
RUN /usr/bin/crontab /etc/cron.d/crontab

# Добавим свой php.ini, можем в нем определять свои значения конфига
ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

EXPOSE 9000

# Указываем рабочую директорию для PHP
WORKDIR /var/www