<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    // Гет запрос для выхода
    if (!empty($_GET['session'])) {
        $_SESSION['reg_check'] = false;
        $_SESSION['role'] = 'none';
        $_GET['session'] = '';
    }

    if ($_SESSION['reg_check'] == true) {

        //Получаем файлы  
        $users_json = file_get_contents('users.json');
        $arr_users = json_decode($users_json, 1);

        $tea_json = file_get_contents('tea.json');
        $arr_tea = json_decode($tea_json, 1);

        // Регистреция классов
        spl_autoload_register();

        // Приветствие
        if ($_SESSION['reg_check'] == true) {
            echo "<div class = 'h1'><h1>Привет " . $_SESSION['name'] . "!</h1></div>";
        }

        // Находим пользователя в списке users
        foreach ($arr_users as $user) {
            if ($user['login'] == $_SESSION['login']) {
                $number = array_search($user, $arr_users);
            }
        }

        // Гет запрос для user_delite
        if (isset($_GET['user_delite'])) {
            unset($arr_users["$number"]['favourites'][array_search($_GET['user_delite'], $arr_users["$number"]['favourites'])]);

            $arr_users["$number"]['favourites'] = array_values($arr_users["$number"]['favourites']);
            $users_json = json_encode($arr_users);
            file_put_contents('users.json', $users_json);
        }

        // Создание объектов массива
        $ObjectTea = [];
        foreach ($arr_tea as $tea) {
            if (in_array($tea['id'], $arr_users["$number"]['favourites'])) {
                $ObjectTea[] = new Tea($tea['name'], $tea['description'], $tea['category'], $tea['price'], $tea['imageUrl'], $tea['stock'], $tea['offer'], $tea['id']);
            }
        }

        // Создание массива с категориями
        $categories = [];
        foreach ($arr_tea as $tea) {
            if (!array_search($tea['category'], $categories)) {
                $categories[] = $tea['category'];
            }
        }
        // Ввывод объектов
        $est_izbranoe = 0;
        foreach ($categories as $category) {
            foreach ($ObjectTea as $key => $Object) {
                if ($category == $Object->getCategory()) {
                    echo '<div class="tea">';
                    $Object->print();

                    // Удалить из избранного
                    if ($_SESSION['role'] == 'user') {
                        ?>
                        <div class="butten">
                            <a class="link" href="?user_delite=<?= $Object->getId() ?>">Удалить из избранного</a> <br>
                        </div>
                        <?php
                    }

                    echo '</div>';

                    $est_izbranoe = 1;
                }
            }
            echo '</div>';
        }

        if ($est_izbranoe == 0) {
            ?>

            <div class="form">
                У вас пока что нет любимых товаров
                <div class="butten2">
                    <a class="link" href="Интернет магазин чая.php">Перейти на страницу с товарами</a>
                </div>
            </div>

            <?php
        }
        ?>

        <!-- Выход из сессии -->
        <div class="session">
            <a class="link" href="?session='1'">Выход из акаунта</a>
        </div>

        <!-- На главную -->
        <div class="main_out">
            <a class="link" href="Интернет магазин чая.php">На главную</a>
        </div>

        <?php
    } else {
        ?>

        <div class="form">
            Пожалуйста авторизируйтесь
            <div class="butten2">
                <a class="link" href="Интернет магазин чая.php">Перейти на страницу авторизации</a>
            </div>
        </div>

        <?php
    }
    ?>

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

        .h1 {
            width: 350px;
            background-color: white;
            text-align: center;
            color: #9932CC;
            margin: 3% auto 2%;
            border: 2px solid black;
            border-radius: 10px;
        }

        .tea {
            width: 600px;
            height: auto;
            font-size: 28px;
            text-align: center;
            color: black;
            background-color: white;
            padding: 20px;
            margin: auto;
            margin-top: 10px;
            margin-bottom: 18px;
            border: 2px solid black;
            border-radius: 20px;
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

        .butten {
            width: 300px;
            height: auto;
            background-color: #4169E1;
            margin: 20px auto 0px auto;
            padding: 2px;
            border-radius: 10px;
            border: 1px solid black;
        }

        .butten2 {
            width: 440px;
            height: auto;
            background-color: #4169E1;
            margin: 20px auto 0px auto;
            padding: 2px;
            border-radius: 10px;
            border: 1px solid black;
        }

        .link {
            font-size: 28px;
            color: white;
            text-decoration: none;
        }

        .link2 {
            font-size: 28px;
            color: #DC143C;
            text-decoration: none;
            margin: auto;
        }

        .center {
            width: 300px;
            text-align: center;
            margin: auto;
        }

        .session {
            position: fixed;
            top: 56em;
            text-align: center;
            right: 5px;
            width: 250px;
            height: auto;
            background-color: #4169E1;
            margin: 10px auto 0px auto;
            padding: 2px;
            border-radius: 10px;
            border: 1px solid black;
        }

        .main_out {
            position: fixed;
            top: 56em;
            text-align: center;
            left: 5px;
            width: 180px;
            height: auto;
            background-color: #4169E1;
            margin: 10px auto 0px auto;
            padding: 2px;
            border-radius: 10px;
            border: 1px solid black;
        }
    </style>
</body>

</html>