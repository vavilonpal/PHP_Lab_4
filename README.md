# Рецепт-сайт 🍳

Проект представляет собой веб-приложение для управления рецептами. Пользователи могут просматривать рецепты, добавлять новые, а также просматривать подробную информацию о каждом рецепте. Сайт использует методы пагинации для удобного просмотра большого количества рецептов.

## Возможности 🚀

- **Просмотр всех рецептов**: Пользователи могут просматривать все рецепты, доступные на сайте.
- **Просмотр последних рецептов**: Отображаются последние добавленные рецепты.
- **Просмотр рецепта по ID**: Каждый рецепт имеет уникальный ID, и пользователи могут просматривать подробную информацию о рецепте по его ID.
- **Добавление нового рецепта**: Пользователи могут отправить форму с данными нового рецепта для его добавления.
- **Пагинация**: Рецепты разбиваются на страницы для удобства просмотра.

## Структура проекта 📂

### `index.php`

Главный файл, обрабатывающий HTTP-запросы и маршрутизацию:
- Определяет маршруты для HTTP-методов `GET` и `POST`.
- Обрабатывает запросы и вызывает соответствующие функции для отображения рецептов или добавления нового рецепта.

### `src/handlers/recipeHandler.php`

Обработчики для работы с рецептами, включая функции для отображения рецептов, добавления новых, валидации и работы с файлами.

### `createRecipeForm.php`

Файл с формой для создания нового рецепта.

### `storage/recipes.json`

Файл JSON, в котором хранятся все рецепты. Приложение считывает этот файл при загрузке и обновляет его при добавлении новых рецептов.

## Установка и запуск ⚙️

1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/ваш-репозиторий.git

2. В терминале перейдя в ддиректорию `public` напишите команду
   ```bash
   php -S localhost:8080
