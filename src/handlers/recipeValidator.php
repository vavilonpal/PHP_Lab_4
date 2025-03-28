<?php

/**
 * @var array $errors Массив для хранения ошибок валидации.
 */
$errors = [];

/**
 * @var array $recipeConstraints Массив с функциями валидации для каждого поля рецепта.
 */
$recipeConstraints = [
    /**
     * Валидация для поля 'id'.
     *
     * @param mixed $id Значение для поля 'id'.
     * @return void
     */
    'id' => function () {

    },
    /**
     * Валидация для поля 'title' (Название рецепта).
     * Проверяет, что поле не пустое и не превышает максимальную длину.
     *
     * @param string $title Название рецепта.
     * @return bool Возвращает true, если валидация прошла успешно, иначе false.
     */
    'title' => function ($title) {
        return isNotBlank($title, "title") && maxLength($title, "title", 12);
    },

    /**
     * Валидация для поля 'category' (Категория рецепта).
     *
     * @param string $category Категория рецепта.
     * @return void
     */
    'category' => function () {

    },

    /**
     * Валидация для поля 'description' (Описание рецепта).
     * Проверяет, что описание не превышает заданную максимальную длину.
     *
     * @param string $description Описание рецепта.
     * @return bool Возвращает true, если валидация прошла успешно, иначе false.
     */
    'description' => function ($description) {
        return maxLength($description, "description", 100);
    },

    /**
     * Валидация для поля 'ingredients' (Ингредиенты).
     *
     * @param mixed $ingredients Ингредиенты рецепта.
     * @return void
     */
    'ingredients' => function () {

    },

    /**
     * Валидация для поля 'steps' (Шаги приготовления).
     * Проверяет, что количество шагов не меньше заданного минимального значения.
     *
     * @param array $steps Шаги приготовления рецепта.
     * @return bool Возвращает true, если валидация прошла успешно, иначе false.
     */
    'steps' => function ($steps) {
        return minStepsCount($steps, 3);
    },

    /**
     * Валидация для поля 'tags' (Тэги).
     *
     * @param array $tags Тэги рецепта.
     * @return void
     */
    'tags' => function () {

    },
];

/**
 * Функция валидации рецепта.
 * Проходит по всем полям рецепта и применяет соответствующие функции валидации.
 *
 * @param array $recipe Массив с данными рецепта.
 * @return bool Возвращает true, если все поля прошли валидацию, иначе false.
 */
function validateRecipe($recipe): bool
{
    global $errors;
    global $recipeConstraints;

    foreach ($recipe as $key => $value) {
        $recipeConstraints[$key]($value);
    }

    if (empty($errors)) {
        return true;
    }

    print_r($errors);
    return false;
}

/**
 * Проверяет, что поле не пустое.
 *
 * @param string|int $field Значение поля.
 * @param string $fieldName Название поля.
 * @return bool Возвращает true, если поле не пустое, иначе false.
 */
function isNotBlank($field, $fieldName)
{
    global $errors;

    if (empty($field)) {
        $errors[$fieldName] = "This field is required";
        return false;
    }

    return true;
}

/**
 * Проверяет, что количество шагов не меньше минимального значения.
 *
 * @param array $steps Массив шагов рецепта.
 * @param int $stepsCount Минимальное количество шагов.
 * @return bool Возвращает true, если количество шагов соответствует минимальному значению, иначе false.
 */
function minStepsCount($steps, int $stepsCount)
{
    global $errors;

    if (empty($steps)){
        $errors['steps'] = "Recipe must be at least $stepsCount steps";
        return false;
    }
    if (count($steps) < $stepsCount) {
        $errors['steps'] = "Recipe must be at least $stepsCount steps";
        return false;
    }

    return true;
}

/**
 * Проверяет, что длина строки не превышает заданного максимума.
 *
 * @param string $field Значение поля.
 * @param string $fieldName Название поля.
 * @param int $maxLength Максимальная длина.
 * @return bool Возвращает true, если длина строки меньше или равна максимальной длине, иначе false.
 */
function maxLength($field, $fieldName, $maxLength)
{
    global $errors;

    if (strlen($field) > $maxLength){
        $errors[$fieldName] = "Maximum of $maxLength characters allowed";
        return false;
    }

    return true;
}



