# Чат на websocket с использованием Laravel + Vue

### Запуск проекта (Разработка)

В начале необходимо перейти в корневую папку проекта и создать .env, пример данных можно взять из .env.example.
Также создать .env в папку frontend-vue

Установка завимостей.

```
composer i

cd frontend-vue
npm i
```

Запуск mysql субд.

```
docker compose -f docker-compose.dev.yaml up
```

Генерация ключей приложения

```
php artisan key:generate
php artisan reverb:install
```

Сгенерированный ключ REVERB_APP_KEY надо указать в файле /frontend-vue/.env

Применение миграций.

```
php artisan migrate --seed
```

Запуск приложения.

```
composer run dev
```

Открытие новой консоли в текущей директории

```
cd frontend-vue
npm run dev
```

Открытие второй новой консоли в текущей директории

```
php artisan reverb:start
```

### Использование

Сайт изначально запускается по такому пути http:/localhost:5173
