# laravel-cars-parser

Базовый скрипт-концепт на Laravel 11 и Docker для сбора данных с корейского автопортала Encar.

## Основное
* **Стек:** Laravel 11 (PHP 8.2), Nginx, MySQL, Docker + Docker Compose.
* **Функции:** запуск через Artisan-команду `app:cars-parser`, запросы к API с подменой заголовков, сохранение результатов в `cars.json`.
* **MVP-статус:** для продакшена и больших объемов потребуется добавить прокси, ротацию User-Agent и очереди задач.

## Быстрый запуск

1. Клонируйте репозиторий и настройте окружение:
   ```bash
   git clone https://github.com
   cd laravel-cars-parser
   cp .env.example .env
   ```
2. Поднимите контейнеры и инициализируйте проект:
   ```bash
   docker compose up -d --build
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan app:cars-parser
   ```
3. Искомый файл с результатами появится по пути `storage/app/cars.json`. Для остановки используйте `docker compose down`.
