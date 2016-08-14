<?php
/*
HomeWork: 3
Task: 4
Author: Korsic
 */

/*

Создайте систему регистрации и авторизации. Регистрационные данные должны быть записаны в базе данных в открытом виде, без шифрования.

Создайте форму, в которой будут иметься поле для ввода имени, возраста и описания о себе. Поля не могут содержать HTML код

Добавьте поле “фотограф]ия”, которое загрузит файл с картинкой. Все остальные типы файлы не должны быть загружены.

Файл поместите в папку “photos”, а остальные поля сохраните в базу данных

Добавьте функциональность вывода списка файлов в директории “photos”, иметь возможность удаления и переименовывания файлов (загруженных своим пользователем), с занесением обновлений в БД

Доступ ко всему функционалу доступен только авторизованному пользователю.

Пользователь может выбрать аватарку из списка загруженных им фотографий

*/

require_once('my_class.php');
require_once ('function.php');

# При первом выполнении скрипта проверяем наличие нужной БД, если нет - создаем
$temp = new first_run_program("homework4");
$temp->check_and_create_database();

?>
    <div style="float: left">
        <form action="" method="post">
            <p>Username: <input title="" type="text" name="Username_Login" /></p>
            <p>Password: <input title="" type="text" name="Password_Login" /></p>
            <input type="submit" name="Login" value="Авторизация" />
        </form>
    </div>
    <div style="float: left; margin-left: 50px">
        <form action="" method="post">
            <p>Username: <input title="" type="text" name="Username_Reg" /></p>
            <p>Password: <input title="" type="text" name="Password_Reg" /></p>
            <p>Confirm Password: <input title="" type="text" name="ConfirmPassword" /></p>
            <input type="submit" name="Registration" value="Регистрация" />
        </form>
    </div>

<?php


$post_username_reg = $_POST['Username_Reg'];
$post_password_reg = $_POST['Password_Reg'];
$post_confirmpassword = $_POST['ConfirmPassword'];

$post_username_login = $_POST['Username_Login'];
$post_password_login = $_POST['Password_Login'];


## Обрабатываем ввод логина
if (isset($post_username_login) || isset($post_password_login)) {
    if (empty($post_username_login) || empty($post_password_login)) {
        echo "Введите данные для логина полностью!";
    } else {
// Проверяем на существование такого пользователя
        $user = check_username($post_username_login);

        if (empty($user)) {
            echo "Такого пользователя не существует, проверьте правильность введенных данных";
        } elseif ($user['password'] == $post_password_login) {
// Проверяем на корректный пароль пользователя и если корректный - перенаправляем на страницу залогиненного юзера
            session_start();
            // Тестирую передачу ID юзера
            $_SESSION['id'] = $user['id'];
            //var_dump($_SESSION['id']);
            //exit();

            echo '<script type="text/javascript">
                window.location = "main.php"
                </script>';


        } else {
            echo "Пароль неверный";
        }
    }
}

## Обрабатываем регистрацию
if (isset($post_username_reg) || isset($post_password_reg) || isset($post_confirmpassword)) {
// Очищаем username от html тегов
    $post_username_reg= strip_tags ($post_username_reg);

    if (empty($post_username_reg) || empty($post_password_reg) || empty($post_confirmpassword)) {
        echo "<b>Введите данные для регистрации полностью!</b>";
    } else {
// Валидируем все поля на допустимый размер и проверяем совпадают ли пароли
        $good_data = true;
        if (mb_strlen($post_username_reg) > 100) {
            echo "Имя должно быть менее символов<br />";
            $good_data = false;
        }
        if ($post_password_reg != $post_confirmpassword) {
            echo "Пароли должны совпадать!<br />";
            $good_data = false;
        }
        if ((mb_strlen($post_password_reg) > 50) || (mb_strlen($post_confirmpassword) > 50)) {
            echo "Пароль должен быть менее 50 символов<br />";
            $good_date = false;
        }
        if (true == $good_data) {
// Проведяем на наличие имени пользователя в базе
            $db = new mysqli("localhost", "root", "root", 'homework4');
            if ($db->connect_errno) {
                echo "ошибка подключения к БР";
            }
            $result = $db->query("select * from users where username = '$post_username_reg' LIMIT 0,1");
            $record = $result->fetch_assoc();
            if (!empty($record)) {
                echo "Такой пользователь уже существует, возьмите другой ник";
            } else {
                $db->query("INSERT INTO `users` (username, password) VALUES ('$post_username_reg', '$post_password_reg')");
                echo "<br />Пользователь зарегистрирован!";
            }
        } else {
            echo "Что-то с введеными данными не так :)";
        }
    }
}






