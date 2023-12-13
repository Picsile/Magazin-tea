<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Запуск сессии
    session_start();

    
    //Получаем файлы
    $users_json = file_get_contents('users.json');
    $arr_users = json_decode($users_json, 1);

    // Переменные
    $password_true = 0;

    // Проверка пароля и запись пользователя
    if (!empty($_POST)) {
        if ($_POST['password1'] === $_POST['password2']) {
            $arr_users[] = ['name' => $_POST['name'], 'email' => $_POST['email'], 'login' => $_POST['login'], 'password' => $_POST['password1'], 'role' => 'user'];
            $password_true = 1;
            $_SESSION['role'] = 'user';
        } else $password_true = '<div class = "warning">Введенные пароли не совпадают</div>'; 
    }

    // Успешная регистрация
    if ($password_true != 1) {
    ?>

    <div class="form">
        <form action="" method="POST">
            <b>Регистрация</b> <br>
            Введите имя: <br>
            <input required name="name"></input> <br>
            Введите email: <br>
            <input required name="email"></input> <br>
            Введите логин: <br>
            <input required name="login"></input> <br>
            Введите пароль: <br>
            <input required name="password1"></input> <br>
            Подтверждение пароля: <br>
            <input required name="password2"></input> <br>

            <?php
            if ($password_true == '<div class = "warning">Введенные пароли не совпадают</div>') {
                echo $password_true;
            }
            ?>

            <input type="submit"></input>

            <div class="butten">
                 <a class="link" href="Интернет магазин чая.php">Перейти на страницу с товарами</a>
             </div>
        </form>

        
    </div>
    <?php
    } else {
    ?>
    <div class="form">
    Вы успешно Зарегестрированы! <br>

    <div class="butten">
        <a class="link" href="Интернет магазин чая.php">Перейти на страницу с товарами</a>
    </div>

    </div>
    <?php
    }
    // Перезапись файла
    $users_json = json_encode($arr_users);
    file_put_contents('users.json', $users_json);
    ?>

    <!-- Стили -->
    <style>
        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        body {
            background-image: url(Фон.jpg);
            background-size: 20%;
        }

        .form {
            width: 530px;
            height: auto;
            font-size: 28px;
            text-align: center;
            background-color: white;
            padding: 20px 0 20px 0;
            margin: 150px auto;
            border: 2px solid black;
            border-radius: 20px;
        }

        input,
        select,
        textarea {
            width: 300px;
            height: 35px;
            max-width: 450px;
            max-height: 90px;
            font-size: 21px;
            margin: 12px 0 12px 0;
        }

        .warning {
            color: red;
        }

        .butten {
            width: 430px;
            height: auto;
            background-color: #4169E1;
            margin: 20px auto 0px auto;
            padding: 2px;
            border-radius: 10px;
            border: 1px solid black;
        }

        .link {
            color: white;
            text-decoration: none;
        }
    </style>
</body>

</html>