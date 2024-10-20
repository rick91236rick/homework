# Npm install dependencies
FROM node:18 AS node_modules

WORKDIR /var/www/html

COPY package*.json ./
RUN npm install

# The base for local development environment
FROM ubuntu:20.04 AS base

ARG PHP_VERSION=8.2

ENV DEBIAN_FRONTEND=noninteractive

RUN set -eux \
    && apt update \
    && apt-get install -yq --no-install-recommends \
        curl apt-transport-https gnupg2 software-properties-common ca-certificates lsb-release \
    # Add apt repo from ppa:ondrej/php
    && add-apt-repository ppa:ondrej/php \
    && apt update \
    && apt-get install --no-install-recommends -yq \
        pkg-config autoconf dpkg-dev file g++ libc-dev re2c \
        netbase gzip zip unzip supervisor \
        # For imagick extecsion
        libmagickwand-dev \
        # Install PHP & extensions
        php${PHP_VERSION}-dev php-pear php${PHP_VERSION}-bcmath php${PHP_VERSION}-curl php${PHP_VERSION}-mbstring php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-opcache php${PHP_VERSION}-readline php${PHP_VERSION}-soap php${PHP_VERSION}-xml \
        php${PHP_VERSION}-xmlrpc php${PHP_VERSION}-zip php${PHP_VERSION}-sockets php${PHP_VERSION}-cli \
    # Nodejs 18.x
    && curl -sL https://deb.nodesource.com/setup_18.x | bash -  \
    && apt-get install -y --no-install-recommends \
        nodejs \
    # For cryptaes104 extension
    && apt-get install -y \
        rsyslog \
    # Clear
    && apt autoremove -y \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

RUN set -eux \
    && pecl channel-update pecl.php.net
    # Install PHP extensions with pecl

# Set timezone
ENV TZ=Asia/Taipei
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Set file permissions for Supervisord
RUN set -eux \
    # Supervisord pid
    && chown -R www-data:www-data /var/run \
    && chmod -R ug+rw /var/run \
    # Set directory permission
    && mkdir -p /var/www/ \
    && chown -R www-data:www-data /var/www

# Local development environment
FROM base AS local

ARG GITHUB_TOKEN

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set github token for composer
RUN composer config -g github-oauth.github.com ${GITHUB_TOKEN}

# Copy dependencies
COPY --from=node_modules /var/www/html/node_modules /var/www/html/node_modules

WORKDIR /var/www/html
EXPOSE 8080
