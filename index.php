<?php

// Запускаем сессию (один раз для всего сайта)
session_start();
/*
// проверяем и генерируем CSRF-токен, если его еще нет
if (empty($_SESSION['csrf_token'])) {
    // random_bytes доступен в PHP 7 и PHP 8, генерирует криптографически безопасный ключ
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}


require_once 'config.php';
require 'init.php';

*/
// подключаем БД
require 'connect.php';
//подключаем функции
require 'functions.php';



$url = $_SERVER['REQUEST_URI'];
$routeMatched = false;


// страница регистрации пользователя
$route = '^/register$';
if (preg_match("#$route#", $url, $params)) {
    $page = include 'view/page/register.php';
    $routeMatched = true;
}


// категория форума (список топиков)
if (!$routeMatched) {
    $route = '^/(?<categorySlug>[a-z0-9_-]+)(\?sheet=[0-9])*$';
    if (preg_match("#$route#", $url, $params)) {
        
        $slug = $params['categorySlug'];        
       
        $categoryExists = checkCategoryInDatabase($link, $slug); 

        if ($categoryExists) {
            $page = include 'view/page/category.php';
            $routeMatched = true; // Страница найдена в БД, всё ок
        } 
        // Если $categoryExists вернул false, мы НЕ ставим $routeMatched = true,
        // и роутер спокойно провалится ниже, выдав в итоге 404 ошибку!
    }
}

// главная
if (!$routeMatched) {
    $route = '^/$';
    if (preg_match("#$route#", $url, $params)) {
        $page = include 'view/page/main.php';
        $routeMatched = true;
    }
}

// Если ни один маршрут не сработал — отдаем 404
if (!$routeMatched) {
    header("HTTP/1.1 404 Not Found");
    $page = [
        'title' => 'Страница не найдена',
        'content' => '<p>Извините, запрашиваемая страница не существует на форуме.</p>'
    ];
}


// 1. Включаем буферизацию вывода
ob_start();
// 2. Подключаем файл шаблона (теперь PHP в нем выполнится!)
include 'layout.php';
// 3. Записываем результат выполнения в переменную
$layout = ob_get_clean();
// 4. Заменяем текстовые маркеры (переменные $page должны быть доступны)
$layout = str_replace('{{ title }}', $page['title'], $layout);
$layout = str_replace('{{ content }}', $page['content'], $layout);
// 5. Выводим готовую страницу
echo $layout;

?>