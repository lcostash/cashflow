FROM php:8.2-fpm AS production
# Set working directory inside container
WORKDIR /var/www/html
# Install system dependencies
RUN <<EOF
  apt-get update
  apt-get install -y git zip unzip curl wget ca-certificates rsync libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev
  docker-php-ext-install intl pdo pdo_mysql zip opcache mbstring exif pcntl bcmath gd
  docker-php-ext-enable opcache
  rm -rf /var/lib/apt/lists/*
EOF
# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
# Add Composer global bin to PATH
ENV PATH="/root/.composer/vendor/bin:/root/.config/composer/vendor/bin:${PATH}"
# Copy project files from src/ (relative to compose.yaml context)
COPY ./src/ ./
EXPOSE 9000
CMD ["php-fpm"]


FROM production AS development
# Install laravel
RUN composer global require laravel/installer
# Install NVM and Node.js
RUN wget -qO- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash
ENV NVM_DIR=/root/.nvm
ENV NODE_VERSION=22.12.0
RUN <<EOF
  . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
  . "$NVM_DIR/nvm.sh" &&  nvm use v${NODE_VERSION}
  . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
  cp /root/.nvm/versions/node/v${NODE_VERSION}/bin/node /usr/bin/
  cp /root/.nvm/versions/node/v${NODE_VERSION}/bin/npm /usr/bin/
EOF


FROM development AS xdebug
# Install xDebug
RUN <<EOF
  pecl install xdebug
  docker-php-ext-enable xdebug
EOF
# Copy custom xDebug & PHP configurations
COPY ./docker/php/90-xdebug.ini "${PHP_INI_DIR}/conf.d"
COPY ./docker/php/uploads.ini "${PHP_INI_DIR}/conf.d"
