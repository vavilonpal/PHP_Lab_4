<?php

/**
 * Подключает файл валидатора рецептов.
 */
require_once 'recipeValidator.php';

/**
 * Имя файла с рецептами.
 *
 * @var string
 */
$fileName = "recipes.json";

/**
 * Путь к файлу с рецептами.
 *
 * @var string
 */
$filePath = "../storage/" . $fileName;

/**
 * Массив рецептов, загруженных из файла.
 *
 * @var array
 */
$recipes = getRecipesByFilePath($filePath);

/**
 * Отображает рецепт по его ID.
 *
 * @param int $recipeId Идентификатор рецепта.
 * @return void
 */
function showRecipeById(int $recipeId): void
{
    global $recipes;
    foreach ($recipes as $recipe) {
        if ($recipe['id'] == $recipeId) {
            showRecipe($recipe);
        }
    }
}

/**
 * Отображает все рецепты.
 *
 * @return void
 */
function showAllRecipes(): void
{
    global $recipes;
    if (!$recipes) {
        echo "<p>Рецептов пока нет.</p>";
        return;
    }
    foreach ($recipes as $recipe) {
        showRecipe($recipe);
    }
}

/**
 * Отображает последние два рецепта.
 *
 * @return void
 */
function showLastRecipes(): void
{
    global $recipes;
    if (!$recipes) {
        echo "<p>Рецептов пока нет.</p>";
        return;
    }

    $lastRecipes = array_slice($recipes, -2);
    foreach ($lastRecipes as $recipe) {
        showRecipe($recipe);
    }
}

/**
 * Получает все рецепты из файла.
 *
 * @param string $filePath Путь к файлу с рецептами.
 * @return array Массив рецептов.
 */
function getRecipesByFilePath(string $filePath): array
{
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        if ($jsonData !== false) {
            return json_decode($jsonData, true); // Преобразуем JSON в массив
        } else {
            // Если чтение файла не удалось
            return [];
        }
        return [];
    }
}

/**
 * Функция для вывода рецепта на странице.
 *
 * @param array $recipe Массив с данными рецепта.
 * @return void
 */
function showRecipe(array $recipe): void
{
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>";
    echo "<h2>{$recipe['title']}</h2>";
    echo "<p><strong>Категория:</strong> {$recipe['category']}</p>";
    echo "<p><strong>Описание:</strong> {$recipe['description']}</p>";
    echo "<p><strong>Ингредиенты:</strong>{$recipe['ingredients']}</p>";
    echo "<p><strong>Шаги приготовления:</strong></p><ol>";
    foreach ($recipe['steps'] as $step) {
        echo "<li>$step</li>";
    }
    echo "</ol>";
    echo "<p><strong>Тэги:</strong> " . implode(", ", $recipe['tags']) . "</p>";
    echo "</div>";
}

/**
 * Добавляет новый рецепт в файл.
 *
 * @param array $recipeRequest Массив с данными рецепта из формы.
 * @return void
 */
function addRecipeToFile(array $recipeRequest)
{
    global $recipes, $errors;
    global $filePath;
    $id = 0;

    if (empty($recipes)) {
        $id = 1;
    } else {
        $lastRecipeId = end($recipes)['id'];
        $id = $lastRecipeId + 1;
    }

    $recipe = [
        'id' => $id,
        'title' => $recipeRequest['title'] ?? '',
        'category' => $recipeRequest['category'] ?? '',
        'description' => $recipeRequest['description'] ?? '',
        'ingredients' => $recipeRequest['ingredients'] ?? '',
        'steps' => $recipeRequest['steps'] ?? '',
        'tags' => $recipeRequest['tags'] ?? ''
    ];

    $recipeIsValid = validateRecipe($recipe);
    if ($recipeIsValid) {
        $recipes[] = $recipe;
        file_put_contents($filePath, json_encode($recipes, JSON_PRETTY_PRINT));

        echo "<h2>Рецепт успешно добавлен!</h2>";
        echo "<a href='/'>Перейти к рецептам</a>";
    } else {
        showRecipeForm($errors);
        http_response_code(400);
        return null;
    }
}

/**
 * Отображает рецепты для указанной страницы с пагинацией.
 *
 * @param int $page Номер страницы.
 * @return void
 */
function getPageableRecipes(int $page): void
{
    global $recipes;
    $pageSize = 5;

    $topOfPage = ($pageSize * $page) - $page;
    $endOfPage = $pageSize * $page;

    if ($topOfPage > sizeof($recipes)) {
        echo "Больше рецептов нет";
        return;
    }
    if ($page >= 1) {
        $pageRecipes = array_slice($recipes, $topOfPage, $endOfPage);
        foreach ($pageRecipes as $recipe) {
            showRecipe($recipe);
        }
    } else {
        echo "Укажите страницу";
    }
}
