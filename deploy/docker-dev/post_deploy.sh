#!/bin/sh

php deploy/docker-dev/composer_2.phar dump-autoload;
php artisan config:cache;
php artisan migrate;
chmod -R 777 storage/logs/;
npm i;
npm run build;

# update application cache
php artisan optimize;

# start the application

php-fpm;
