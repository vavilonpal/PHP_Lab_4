<?php

require_once __DIR__ . "/../src/handlers/recipeHandler.php";


/***
 * Данный метод предоставляет форму для создания рецепта
 * @param $errors - массив ошибок для их отображения при повторном получении формы
 * @return void
 */
function showRecipeForm($errors = []): void
{
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Добавить рецепт</title>
        <script>
            function addStep() {
                const stepsContainer = document.getElementById("steps-container");
                const stepCount = stepsContainer.children.length + 1;

                const stepDiv = document.createElement("div");
                stepDiv.innerHTML = `
                <label for="step${stepCount}">Шаг ${stepCount}:</label>
                <input type="text" id="step${stepCount}" name="steps[]" required>
                <button type="button" onclick="removeStep(this)">Удалить</button>
                <br>
            `;

                stepsContainer.appendChild(stepDiv);
            }

            function removeStep(button) {
                button.parentElement.remove();
            }
        </script>
        <style>
            .error {
                color: red;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
    <h2>Добавить рецепт</h2>
    <form
            method="post"
            action="/recipe-add"
            novalidate
            autocomplete="off"
            enctype="multipart/form-data">

        <!-- Название рецепта -->
        <label for="title">Название рецепта:</label>
        <input type="text" id="title" name="title" required>
        <?php if (!empty($errors['title'])): ?>
            <div class="error"><?= $errors['title'] ?></div>
        <?php endif; ?>
        <br><br>

        <!-- Категория -->
        <label for="category">Категория рецепта:</label>
        <select id="category" name="category" required>
            <option value="Завтрак">Завтрак</option>
            <option value="Обед">Обед</option>
            <option value="Ужин">Ужин</option>
            <option value="Десерт">Десерт</option>
        </select>
        <?php if (!empty($errors['category'])): ?>
            <div class="error"><?= $errors['category'] ?></div>
        <?php endif; ?>
        <br><br>

        <!-- Ингредиенты -->
        <label for="ingredients">Ингредиенты:</label><br>
        <textarea id="ingredients" name="ingredients" rows="4" required></textarea>
        <?php if (!empty($errors['ingredients'])): ?>
            <div class="error"><?= $errors['ingredients'] ?></div>
        <?php endif; ?>
        <br><br>

        <!-- Описание -->
        <label for="description">Описание рецепта:</label><br>
        <textarea id="description" name="description" rows="6" required></textarea>
        <?php if (!empty($errors['description'])): ?>
            <div class="error"><?= $errors['description'] ?></div>
        <?php endif; ?>
        <br><br>

        <!-- Тэги -->
        <label for="tags">Тэги:</label>
        <select id="tags" name="tags[]" multiple>
            <option value="вегетарианское">Вегетарианское</option>
            <option value="быстрое">Быстрое</option>
            <option value="полезное">Полезное</option>
            <option value="острое">Острое</option>
        </select>
        <?php if (!empty($errors['tags'])): ?>
            <div class="error"><?= $errors['tags'] ?></div>
        <?php endif; ?>
        <br><br>

        <!-- Шаги приготовления -->
        <label>Шаги приготовления:</label>
        <div id="steps-container"></div>
        <button type="button" onclick="addStep()">Добавить шаг</button>
        <?php if (!empty($errors['steps'])): ?>
            <div class="error"><?= $errors['steps'] ?></div>
        <?php endif; ?>
        <br><br>
        <button type="submit">Добавить рецепт</button>
    </form>
    </body>
    </html>
    <?php
}


