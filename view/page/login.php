<?php    

$content = '';

if (!empty($_POST['password']) and !empty($_POST['login'])) {
    $login = $_POST['login'];
    
    // Получаем юзера по логину и джойним статус:
    $query = "SELECT users.*, statuses.name as status FROM users
        LEFT JOIN statuses
        ON users.status_id=statuses.id 
        WHERE login='$login' AND users.is_deleted = false";

    $res = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($res);

    if (!empty($user)) {
        $hash = $user['password']; // соленый пароль из БД
    
        // Проверяем соответствие хеша из базы введенному паролю
        if (password_verify($_POST['password'], $hash)) {
            // все ок, авторизуем...
            $_SESSION['flash'] = 'Вы успешно прошли авторизацию!';
            $_SESSION['auth'] = true;
            $_SESSION['status'] = $user['status'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $login;
            header('Location: /');
            die();
        } else {
            // пароль не подошел, выведем сообщение				
            $content .= '<p>Введённые Вами логин или пароль неверны.</p>';
        }
    } else {
        // пользователя с таким логином нет, выведем сообщение			
        $content .= '<p>Введённые Вами логин или пароль неверны.</p>';
    }

}

$content .= '<div class="box">
	<h1>Log in</h1>
	<form action="" method="post">
		<label for="login">Login</label>
		<input id="login" name="login" type="text" autocomplete="username" value="';
        
if (isset($_POST['login'])) {
    $content .= $_POST['login'];        
}

        $content .='">
		<label for="password">Password</label>
		<input id="password" name="password" type="password" autocomplete="current-password">
		<div class="acts">
			<button class="btn" type="submit">Log in</button>
			<a class="ghost" href="recover.html">Forgot password</a>
			<a class="ghost" href="/register">Register</a>
		</div>
	</form>
</div>';


$page = [
        'title' => 'Log in — Rack', 
        'content' => $content
    ];

return $page;    

?>