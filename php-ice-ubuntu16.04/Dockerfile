FROM ubuntu:16.04

# Add ZeroC Ice package repository
# install php-fpm and php-ice
RUN apt-get update \
    && apt-get install -y \
        tzdata \
        software-properties-common \
    && apt-key adv --keyserver keyserver.ubuntu.com --recv B6391CB2CFBA643D \
    && apt-add-repository "deb http://zeroc.com/download/Ice/3.7/ubuntu16.04 stable main" \
    && apt-get update \
    && apt-get install -y \
        php-fpm \
        php-zeroc-ice \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy php-fpm config setup to listen on port
COPY www.conf /etc/php/7.0/fpm/pool.d/www.conf

EXPOSE 9000

VOLUME /var/log
VOLUME /var/www
VOLUME /etc/php

# Start php-fpm when container launches
CMD ["/usr/sbin/php-fpm7.0", "--nodaemonize", "--fpm-config", "/etc/php/7.0/fpm/php-fpm.conf"]
