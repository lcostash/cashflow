# Cashflow

<img src="https://img.shields.io/badge/license-MIT-green" alt="License">

A small Laravel application for managing the cash flow. This repository contains is developed utilizes [Livewire](https://livewire.laravel.com), [Tailwind](https://tailwindcss.com), and the [Flux UI](https://fluxui.dev) component library.

## Requirements

1. [Git](https://git-scm.com/install/)
2. [Docker Desktop](https://www.docker.com/products/docker-desktop/)

## Environment Variables

1. Create the `.env.override` file into the root folder of the project. Here we will store the database and email variables. The body should look like example below. Do not forget to change the default passwords or other sensitive information from the example.

   ```bash
   PHP_IDE_CONFIG="serverName=cashflow.local"

   APP_ENV="local"
   APP_KEY="base64:your-base64-string"
   APP_DEBUG=true
   APP_URL="http://cashflow.local"

   LOG_CHANNEL="stack"
   LOG_STACK="single"
   LOG_DEPRECATIONS_CHANNEL=null
   LOG_LEVEL="debug"

   DB_DATABASE="db_database"
   DB_USERNAME="db_username"
   DB_PASSWORD="db_password"

   MYSQL_DATABASE="${DB_DATABASE}"
   MYSQL_USER="${DB_USERNAME}"
   MYSQL_PASSWORD="${DB_PASSWORD}"
   MYSQL_ROOT_PASSWORD="your_mysql_root_password"

   MAIL_MAILER="log"
   MAIL_SCHEME=null
   MAIL_HOST="127.0.0.1"
   MAIL_PORT=2525
   MAIL_USERNAME=null
   MAIL_PASSWORD=null
   MAIL_FROM_ADDRESS="hello@example.com"
   ```

2. Create the `compose.override.yaml` file into the root folder of the project. This will override the docker container's settings. The example below is enable the xDebug which is good for development environment only.

   ```bash
   services:
   app:
       build:
       target: xdebug
       extra_hosts:
       - "host.docker.internal:host-gateway"
   ```

## Quick start

1. Run from the root of the project the `docker compose up -d --build` command to build the images for each service and then start the containers.
2. Next, run the `docker compose exec app bash` to get an interactive prompt.
3. Then, need to install all composer dependences using `composer install` command.
4. Then, need to install all npm dependences using `npm install` command.
5. Then, need to build the project using `npm run build` command.
6. Add into hosts the next address:
   ```bash
   127.0.0.1 cashflow.local
   ```
7. Run database migrations using the next command `php artisan migrate`.
8. Open in browser the address `cashflow.local`.

## License

The Cash Flow is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
