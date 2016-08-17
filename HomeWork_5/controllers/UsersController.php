<?php

/**
 * Created by PhpStorm.
 * User: Korsic
 * Date: 15/08/16
 * Time: 17:10
 */

include_once(ROOT . '/models/Users.php');
include_once(ROOT . '/models/Redirect.php');


class UsersController
{

    public function actionRegistration()
    {
        $username = '';
        $password = '';
        $confirm_password = '';
        $result = '';

        if (isset($_POST['Registration'])) {
            $username = $_POST['Username_Reg'];
            $password = $_POST['Password_Reg'];
            $confirm_password = $_POST['ConfirmPassword'];

            $errors = false;

            if (!Users::checkUsernameRegistration($username)) {
                $errors[] = 'Username введен неверно, он должен быть длиной от 1 до 100 символов';
            }
            if (!Users::checkPasswordRegistration($password, $confirm_password)) {
                $errors[] = 'Пароль введен неверно, он должен быть длиной от 1 до 50 символов, а так же пароли должны совпадать';
            }
            if (Users::checkUsernameExists($username)) {
                $errors [] = 'Такой пользователь уже существует, выберите другой никнейм';
            }

            if ($errors == false) {
                // Сохраняем пользователя в базе данных
                $result = Users::registrationUser($username, $password);
            }
        }
        require_once(ROOT . '/views/users/registration.php');
        return true;
    }

    // Просмотр списка всех пользователей зарегистрированных в системе
    public function actionIndex()
    {
        if(!isset($_SESSION['user'])) {
            Redirect::redirectToPage('views/users/authorization.php');
        }
        // Берем массив с данными всех пользователей на сайте
        $usersList = array();
        $usersList = Users::getUsersListWithIdUsernameNameAgeAbout();

        // Сортируем пользователей по возрасту
        $usersList = Users::sortUsersByAge($usersList);


        require_once(ROOT . '/views/users/index.php');
        return true;
    }

    // Просмотр списка файлов загруженных пользователем по его id в базе
    public function actionFiles()
    {
        $count_files = 0;
        $avatar = null;
        $files = [];
        if (isset($_SESSION['user'])) {
            $files = Users::getFilesListById($_SESSION['user']);
            $count_files = count($files);
            $avatar = Users::getAvatarFileName($_SESSION['user']);
            require_once(ROOT . '/views/users/files.php');
        } else {
            Redirect::redirectToPage('views/users/authorization.php');
        }
        return true;
    }

    // Авторизация и регистрация в системе
    public function actionAuthorization()
    {
        $username = '';
        $password = '';
        $login = false;

        if (isset($_POST['Login'])) {
            $username = $_POST['Username_Login'];
            $password = $_POST['Password_Login'];

            $errors = false;

            if (!Users::checkUsernameExists($username)) {
                $errors [] = 'Такого пользователя не существует, проверьте правильность данных';
            }
            if (!Users::checkPasswordAuthorization($username, $password)) {
                $errors[] = 'Введенный пароль не подходит, проверьте правильность данных';
            }
            if ($errors == false) {
                // Логиним пользователя
                Users::authorizationUser($username);

                // Перенаправляем на страницу просмотра всех пользователей сайте
                Redirect::redirectToPage('views/users/index.php');
            }
        }
        if (isset($_POST['Logout'])) {
            Users::logoutUser();
        }

        require_once(ROOT . '/views/users/authorization.php');
        return true;
    }
}