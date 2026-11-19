<?php

$content = '';

if (!empty($_POST)) {
    // 1. Проверка на заполненность (можно объединить или проверить каждое поле)
    $email = trim($_POST['email'] ?? '');
    $login = trim($_POST['login'] ?? '');    
    $password = $_POST['password'] ?? '';
    $fullname = trim($_POST['fullname'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $city = trim($_POST['city'] ?? '');


    //var_dump($_POST);
    if (empty($email) || empty($login) || empty($password) || empty($fullname) || empty($dob) || empty($country) || empty($city)) {
    //if (empty($email) || empty($login)) {
        $content .= 'Заполните все поля!'; // Или общая ошибка
    } else {
        // 2. Валидация логина
        if (!preg_match('/^[a-zA-Z0-9]*$/', $login)) {
            $message_login = 'Логин должен содержать только латинские буквы и цифры.';
        } elseif (strlen($login) < 4 || strlen($login) > 10) {
            $message_login = 'Логин должен быть длиной от 4 до 10 символов.';
        }

        // 3. Валидация email (проверяем, только если с логином всё ок, или параллельно)
        if (empty($message_login)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message_email = 'Введённый Вами email неверен.';
            }
        }

        // 4. Валидация полного имени
        if (empty($message_login) && empty($message_email)) {
            if (empty($fullname)) {
                $message_fullname = 'Введите полное имя';
            } 
        }

        // 5. Валидация даты
        if (empty($message_login) && empty($message_email) && empty($message_fullname)) {
            if (empty($dob)) {
                $message_date = 'Введите дату рождения';
            } elseif (!preg_match('/^(0[1-9]|[12]\d|3[01])\-(0[1-9]|1[0-2])\-\d{4}$/', $dob)) {
                $formattedDate = $dob;
            }
        }

        // 6. Валидация пароля
        if (empty($message_login) && empty($message_email) && empty($message_fullname) && empty($message_date)) {
            if (strlen($password) < 6 || strlen($password) > 12) {
                $message_pass = 'Пароль должен быть длиной от 6 до 12 символов.';
            }
        }

        // 7. Валидация страны
        if (empty($message_login) && empty($message_email) && empty($message_fullname) && empty($message_date) && empty($message_pass)) {
            if (empty($country)) {
                $message_country = 'Введите страну';
            } 
        }

        // 8. Валидация города
        if (empty($message_login) && empty($message_email) && empty($message_fullname) && empty($message_date) && empty($message_pass) && empty($message_country)) {
            if (empty($city)) {
                $message_city = 'Введите город';
            } 
        }

        // 9. Проверка базы данных и регистрация (если все предыдущие проверки прошли без ошибок)
        if (empty($message_login) && empty($message_email) && empty($message_fullname) && empty($message_date) && empty($message_pass) && empty($message_country)) {
            
            $escapedLogin = mysqli_real_escape_string($link, $login);
            $query = "SELECT * FROM users WHERE login='$escapedLogin'";
            $user = mysqli_fetch_assoc(mysqli_query($link, $query));

            if (!empty($user)) {
                $message_login = 'Такой логин уже занят. Выберите другой!';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $escapedEmail = mysqli_real_escape_string($link, $email);
                
                $query = "INSERT INTO users SET login='$escapedLogin', password='$hashedPassword', date='$formattedDate', email='$escapedEmail', status_id='2', fullname='$fullname', country='$country', city='$city'";
                $res = mysqli_query($link, $query);

                if ($res) {
                    $_SESSION['flash'] = 'Вы успешно прошли регистрацию!';
                    $_SESSION['auth'] = true;
                    $_SESSION['status'] = 'user';
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['login'] = $login;
                    $_SESSION['user_id'] = mysqli_insert_id($link);          
                    
                    header('Location: /');
                    die();
                } else {
                    $content = 'Произошла ошибка при регистрации в базе данных.';
                }
            }
        }


    }
}


$content .= '<div class="box">';
$content .= '<h1>Register</h1>';
$content .= '<form action="" method="post">';
if (isset($message_email)) {
    $content .='<span style="color: red;">' . $message_email . '</span><br>';        
}
$content .= '<label for="reg-email">Email</label>';
$content .= '<input id="reg-email" name="email" type="email" value="';
if (isset($_POST['email'])) {
    $content .= $_POST['email'];        
}
$content .= '">';
if (isset($message_login)) {
    $content .='<span style="color: red;">' . $message_login . '</span><br>';        
}
$content .= '<label for="reg-login">Login</label>';
$content .= '<input id="reg-login" name="login" type="text" value="';
if (isset($_POST['login'])) {
    $content .= $_POST['login'];        
}
$content .='">';
if (isset($message_pass)) {
    $content .='<span style="color: red;">' . $message_pass . '</span><br>';        
}
$content .= '<label for="reg-password">Password</label>';
$content .= '<input id="reg-password" name="password" type="password" value="';
if (isset($_POST['password'])) {
    $content .= $_POST['password'];        
}
$content .= '">';
if (isset($message_fullname)) {
    $content .='<span style="color: red;">' . $message_fullname . '</span><br>';        
}
$content .= '<label for="reg-name">Full name</label>';
$content .= '<input id="reg-name" name="fullname" type="text" value="';
if (isset($_POST['fullname'])) {
    $content .= $_POST['fullname'];        
}
$content .= '">';
if (isset($message_date)) {
    $content .='<span style="color: red;">' . $message_date . '</span><br>';        
}
$content .= '<label for="reg-dob">Date of birth</label>';
$content .= '<input id="reg-dob" name="dob" type="date" value="';
if (isset($_POST['dob'])) {
    $content .= $_POST['dob'];        
}
$content .= '">';
if (isset($message_country)) {
    $content .='<span style="color: red;">' . $message_country . '</span><br>';        
}
$content .= '<label for="reg-country">Country</label>';
$content .= '<input id="reg-country" name="country" type="text" value="';
if (isset($_POST['country'])) {
    $content .= $_POST['country'];        
}
$content .='">';
if (isset($message_city)) {
    $content .='<span style="color: red;">' . $message_city . '</span><br>';        
}
$content .= '<label for="reg-city">City</label>';
$content .= '<input id="reg-city" name="city" type="text" value="';
if (isset($_POST['city'])) {
    $content .= $_POST['city'];        
}
$content .= '">';
$content .= '<div class="acts">
					<button class="btn" type="submit">Create account</button>
					<a class="ghost" href="/login">I already have one</a>
				</div>';
$content .= '</form>';
$content .= '</div>';

$page = [
        'title' => 'Register — Rack', 
        'content' => $content
    ];

return $page;

?>