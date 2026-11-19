<?php
session_start();

//Очищаем данные авторизации
unset($_SESSION['auth']);
unset($_SESSION['user_id']);
unset($_SESSION['fullname']);

$_SESSION['flash'] = 'Вы вышли из аккаунта';

header('Location: /');
exit;
?>