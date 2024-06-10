#!/bin/sh

service postgresql restart
sudo -u postgres psql -c "ALTER USER postgres WITH PASSWORD '12345678';"
sudo -u postgres psql -c "create database example_app;"

php deploy/all_in_one/composer_2.phar update
php deploy/all_in_one/composer_2.phar dump-autoload

chmod -R 777 storage/logs/
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan config:cache
php artisan migrate

php artisan db:seed
php artisan db:seed
php artisan l5-swagger:generate

set -e

cron

exec apache2-foreground
