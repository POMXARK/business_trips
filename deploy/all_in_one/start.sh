#!/bin/sh

service postgresql restart
sudo -u postgres psql -c "ALTER USER postgres WITH PASSWORD '12345678';"
sudo -u postgres psql -c "create database example_app;"

#cd storage/
#mkdir -p framework/{sessions,views,cache}
#

mkdir storage/framework
mkdir storage/framework/cache

chown -R www-data:www-data framework
chown -R www-data storage

chmod -R 777 storage/framework
chmod -R 777 storage/framework/cache

chmod -R 777 storage/logs/
chmod -R 777 bootstrap/cache/

mkdir -p storage/framework/views
mkdir -p storage/framework/sessions
mkdir -p storage/framework/cache/data

chmod -R 777 storage
chmod -R 777 bootstrap/cache

composer install
composer update
composer du

chmod -R 777 storage

php artisan migrate

php artisan l5-swagger:generate
php artisan db:seed
php artisan db:seed

ls -ld storage/framework/cache
ls -a storage/framework
ls -a
ls -a storage

php artisan route:list

set -e

cron

exec apache2-foreground
