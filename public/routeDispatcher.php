<?php

// Подключаем необходимые обработчики и форму для создания рецепта
require_once __DIR__ . "/../src/handlers/recipeHandler.php";
require_once __DIR__ . "/createRecipeForm.php";

// Получаем метод запроса (GET или POST)
$method = $_SERVER['REQUEST_METHOD'];

/**
 * Массив маршрутов для обработки запросов.
 *
 * @var array
 */
$routes = [
    'GET' => [
        '/' => function () {
            // Отображение последних рецептов
            showLastRecipes();
        },
        '/recipes' => function () {
            // Отображение всех рецептов
            showAllRecipes();
        },
        '/recipe-page' => function () {
            // Пагинация рецептов по страницам
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                getPageableRecipes($page); // Отображение рецептов на указанной странице
            } else {
                notFound(); // Если страница не указана - ошибка 404
            }
        },
        '/recipe-id/(\d+)' => function ($recipeId) {
            // Отображение рецепта по ID
            showRecipeById($recipeId);
        },
        '/recipe-create' => function () {
            // Отображение формы для создания нового рецепта
            showRecipeForm();
        }
    ],
    'POST' => [
        '/recipe-add' => function () {
            // Обработка добавления нового рецепта
            $recipeRequest = $_POST;
            addRecipeToFile($recipeRequest);
        }
    ]
];

/**
 * Получает маршрут по URL и HTTP-методу и вызывает соответствующее действие.
 *
 * Применяет регулярные выражения для обработки динамических URL с параметрами.
 *
 * @param string $url URL запроса.
 * @param string $method HTTP-метод запроса (например, GET или POST).
 * @return void
 */
function getRouteByUrl(string $url, string $method): void
{
    global $routes;

    // Проверяем, есть ли маршруты для указанного метода
    if (isset($routes[$method])) {
        // Проходим по всем маршрутам для данного метода
        foreach ($routes[$method] as $route => $action) {
            // Создаем регулярное выражение для поиска параметров в URL
            $pattern = "@^" . preg_replace('/\(\d+\)/', '(\d+)', $route) . "$@";

            // Сравниваем URL с паттерном
            if (preg_match($pattern, $url, $matches)) {
                // Убираем первый элемент массива (первый элемент — это сам URL без параметров)
                array_shift($matches);

                // Выполняем действие для найденного маршрута
                $action(...$matches);
                exit; // Завершаем выполнение скрипта после обработки маршрута
            }
        }
    }

    // Если маршрут не найден, показываем ошибку 404
    notFound();
}

/**
 * Отображает ошибку 404 "Страница не найдена".
 *
 * @return void
 */
function notFound(): void
{
    http_response_code(404); // Устанавливаем HTTP-статус 404
    echo "<h1>404 Not Found</h1>"; // Выводим сообщение об ошибке
}





