<?php


class Users
{

    // Возвращает объект $user с данными пользователя если он существует и false если нет
    public static function getUserDataByUsername($username)
    {
        $db = Db::getConnection();
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 0,1";
        $user = $db->prepare($sql);
        $user->bindParam(':username', $username, PDO::PARAM_STR);
        $user->execute();

        return $user;
    }

    // bool. Возвращает true если пароль совпадает и false если нет
    public static function checkPasswordAuthorization($username, $password)
    {
        $user = Users::getUserDataByUsername($username);
        $user = $user->fetch();

        if ($password == $user['password']) {
            return true;
        } else {
            return false;
        }
    }

    // bool. Возвращает true если Username занят и false если такого пользователя нет
    public static function checkUsernameExists($username)
    {
        $user = Users::getUserDataByUsername($username);

        if ($user->fetchColumn()) {
            return true;
        }
        return false;
    }

    // bool. Возвращает true если Username корректный
    public static function checkUsernameRegistration($username)
    {
        if ((mb_strlen($username) >= 1) && (mb_strlen($username) <= 100)) {
            return true;
        }
        return false;
    }

    // bool. Возвращает true если пароль корректный
    public static function checkPasswordRegistration($password, $confirm_password)
    {
        if ((mb_strlen($password) >= 1) && (mb_strlen($password) <= 50)) {
            if ($password == $confirm_password) {
                return true;
            }
        }
        return false;
    }

    // bool: Возвращает true если регистрация удалась и false если нет
    public static function registrationUser($username, $password)
    {
        $db = Db::getConnection();
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $result = $db->prepare($sql);

        $result->bindParam(':username', $username, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    // bool: Возвращает true если логин удался и false если нет
    public static function authorizationUser($username)
    {
        $user = Users::getUserDataByUsername($username)->fetch();
        $_SESSION['user'] = $user['id'];
    }

    // Возвращает массив пользователей отсортированных по возрасту по убыванию
    public static function sortUsersByAge($usersList)
    {
        foreach ($usersList as $user => $row) {
            $age[$user] = $row['age'];
        }
        array_multisort($age, SORT_DESC, $usersList);
        return $usersList;
    }

    // Возвращаем массив со списком всех пользователей и полями : ID, Username, Имя, Возраст, Описание
    public static function getUsersListWithIdUsernameNameAgeAbout()
    {
        $db = Db::getConnection();
        $sql = "SELECT id, username, name, age, about FROM users";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $user = $result->fetchAll();
        return $user;
    }

    // Возвращает массив со списком всех пользователей зарегистрированных на сайте
    // Не пригодилась в коде
    /*public static function getUsersList()
    {

        $db = Db::getConnection();
        $sql = "SELECT * FROM users";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $user = $result->fetchAll();
        return $user;
    }*/

    // Возвращает путь к аватарке пользователя в таблице photo или false если таковой нет
    public static function getAvatarFileName($id)
    {
        // Получаем ID аватарки пользователя
        $db = Db::getConnection();
        $sql = "SELECT avatar FROM users WHERE id = '$id' LIMIT 0,1";
        $avatarId = $db->query($sql);
        $avatarId->setFetchMode(PDO::FETCH_ASSOC);
        $avatarId = $avatarId->fetch();
        $avatarId = $avatarId['avatar'];

        // Берем путь до аватарки пользователя
        $sql = "SELECT file FROM photo WHERE id = '$avatarId' LIMIT 0,1";
        $avatarFileName = $db->query($sql);
        $avatarFileName->setFetchMode(PDO::FETCH_ASSOC);
        $avatarFileName = $avatarFileName->fetch();
        $avatarFileName = $avatarFileName['file'];

        // Если аватарка найдена - определяем путь до нее на диске
        if (isset($avatarFileName)) {
            $WayAvatar = "../../../Homework_4/" . $avatarFileName;
            return $WayAvatar;
        }
        return false;
    }

    // Возвращает массив со всеми файлами загруженными пользователей с указанным ID или false если файлов нет
    public static function getFilesListById($id)
    {
        $db = Db::getConnection();
        $sql = "SELECT file FROM photo WHERE user_id = '$id'";

        $files = $db->query($sql);
        $files->setFetchMode(PDO::FETCH_ASSOC);
        $files = $files->fetchAll();

        return $files;
    }

    // Разлогиниваем пользователя
    public static function logoutUser () {
        unset($_SESSION["user"]);
        session_destroy();
    }
}