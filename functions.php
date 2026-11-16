<?php

// Функция проверяет, существует ли категория в БД
function checkCategoryInDatabase($link, $slug) {
    // Безопасность: защищаем переменную от SQL-инъекций
    $slug = mysqli_real_escape_string($link, $slug);
    
    $result = mysqli_query($link, "SELECT id FROM categories WHERE slug='$slug'");
    
    // Проверяем, что запрос выполнился И в базе нашлась хотя бы одна строка (кол-во строк > 0)
    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

?>