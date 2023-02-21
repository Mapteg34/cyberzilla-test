# Тестовое задание для CyberZilla

## Формулировка задачи

Реализовать CRUD-интерфейс списка пользователей и их платежей на Laravel и Vue.js
Сделать возможность редактирования данных пользователя (email, имя, номер телефона) и просмотра его платежей

1) Весь front-end реализовать на Vue.js через API к back-end на Laravel
2) Всё должно быть под авторизацией, в т.ч. API
   API:
   GET /users
   GET /users/1
   POST /users
   DELETE /users
   GET /users/1/payments

Тестовое нужно сделать и показать развернутое и код.

Нужно показать фактический проект.
Чтобы был веб доступ.
Хоть в докере, хоть в чем + код.
Но в продакшене докера у нас нет.

## Фактический проект

https://cyberzilla.malahov-artem.ru

## Разворачивание локально

```
$ nano docker-compose.override.yml # @see docker-compose.override.yml.example
$ echo "APP_KEY=$(docker-compose exec -u www-data fpm php artisan key:generate --show --no-ansi)" > .env && ssh-keygen -t rsa -b 2048 -m PEM -f private.pem -N "" && rm private.pem.pub && openssl rsa -in private.pem -pubout -outform PEM -out public.pem && echo "JWT_PRIVATE_KEY='`cat ./private.pem`'" >> .env && echo "JWT_PUBLIC_KEY='`cat ./public.pem`'" >> .env && rm -Rf private.pem public.pem
$ pushd frontend && npm install && popd
$ docker-compose up -d
$ docker-compose exec -u www-data fpm php composer-2.2.4.phar install
$ docker-compose exec -u www-data fpm php artisan migrate:fresh --seed
```

Далее можно открыть в браузере `http://127.0.0.1:<выбранный вами порт>/`.

Для входа в систему `test-cyberzilla@malahov-artem.ru:BqlxFiMYHmCdjnDngJiTpJTgtuAZGQwk`.