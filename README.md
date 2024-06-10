# Сервис бронирования автомобилей.

### Запуск
- cp .env.example .env
- php artisan optimize
- chmod -R 777 storage/logs
- docker-compose --env-file .env.docker-dev -f deploy/docker-dev/docker-compose.yml up --build -d

или Laravel Sail

### demo-deploy (all in one)
- sudo rm -r docker
- sudo chmod -R 777 ./
- docker build -t example-app -f deploy/all_in_one/Dockerfile .
- docker run -d -p 8000:80 --name example-app example-app
