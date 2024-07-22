FROM php:8.1.1-fpm

ENV TZ=${TZ}

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

# Install Supervisor.
RUN \
  apt-get update && \
  apt-get install -y supervisor && \
  rm -rf /var/lib/apt/lists/* && \
  sed -i 's/^\(\[supervisord\]\)$/\1\nnodaemon=true/' /etc/supervisor/supervisord.conf

RUN pecl install --force redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# creating the log file that will be written to at each cron iteration
RUN touch test_cron.log

ADD "https://www.random.org/cgi-bin/randbyte?nbytes=10&format=h" skipcache
# copy the crontab in a location where it will be parsed by the system
COPY ./crontab /etc/cron.d/crontab
# owner can read and write into the crontab, group and others can read it
RUN chmod 0644 /etc/cron.d/crontab
# running our crontab using the binary from the package we installed
RUN /usr/bin/crontab /etc/cron.d/crontab

# Добавим свой php.ini, можем в нем определять свои значения конфига
ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

EXPOSE 9000

#SET TIMEZONE EUROPE/MOSCOW
# RUN rm -rf /etc/localtime && ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
# RUN ln -snf /usr/share/zoneinfo/Europe/Moscow /etc/localtime && echo Europe/Moscow > /etc/timezone

# Указываем рабочую директорию для PHP
WORKDIR /var/www

CMD ["supervisord"]