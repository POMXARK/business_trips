#!/bin/sh

export $(grep -v '^#' .env.docker-prod | xargs)

service postgresql restart
sudo -u postgres psql -c "ALTER USER postgres WITH PASSWORD '12345678';"
sudo -u postgres psql -c "create database example_app;"

mkdir storage/framework
mkdir storage/framework/cache

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
composer du

chmod -R 777 storage

php artisan migrate --force

php artisan db:seed --force
php artisan db:seed --force

sudo -u postgres psql -d example_app -c "SELECT * FROM pg_catalog.pg_tables;"

php artisan l5-swagger:generate

set -e

env

cron

exec apache2-foreground
