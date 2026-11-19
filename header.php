<?php
// Безопасно проверяем, авторизован ли пользователь
$isAuth = !empty($_SESSION['auth']);

if ($isAuth) {
    // Если имя есть — показываем его, если нет — дефолтный текст «Профиль»
    $displayName = !empty($_SESSION['fullname']) ? $_SESSION['fullname'] : 'Профиль';
    
    echo '<a href="/profile">' . htmlspecialchars($displayName) . '</a>';
    echo '<a href="/logout">Log out</a>';
} else {    
    echo '<a href="/register">Register</a>';
    echo '<a href="/login">Login</a>';
}
?>