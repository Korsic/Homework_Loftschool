<?php
/**
 * Created by PhpStorm.
 * User: Korsic
 * Date: 13/08/16
 * Time: 13:52
 */

require_once('function.php');


# При первом выполнении скрипта проверяем наличие нужной БД, если нет - создаем
class first_run_program {

    public $database_name = "database";

    function __construct($database) {
        $this->database_name = $database;
    }

    public function check_and_create_database() {
        $mysqli = new mysqli("localhost", "root", "root");
        if ($mysqli->connect_errno) {
            exit("Не удалось подключиться к MySQL: " . $mysqli->connect_error);
        } else {
// Проверяем на наличие БД в базе

# Подумать, возможно получится оптимизировать без создания переменной $db

            $db = new mysqli("localhost", "root", "root", $this->database_name);
            if ($db->connect_errno) {
                //echo "Базы данных $this->database_name не существует";
                $mysqli->query("CREATE DATABASE IF NOT EXISTS $this->database_name");
// Создем таблицы в БД
                $mysqli->select_db($this->database_name);
                $mysqli->query("CREATE TABLE users (
                                                        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                                                        username VARCHAR(100), 
                                                        password VARCHAR(50),
                                                        name VARCHAR(50),
                                                        age INT UNSIGNED,                                                      
                                                        about VARCHAR(1000), 
                                                        avatar INT UNSIGNED
                                                    ) DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1"
                );
                $mysqli->query("CREATE TABLE photo (
                                                        id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                                                        user_id INT UNSIGNED,
                                                        file VARCHAR(200)
                                                    ) DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1"
                );
            }
        }
    }
}

class model_user {
    # Функция меняет все данные о пользователя
    public function change_data($id, $username, $password, $name, $age, $about) {
// Проверяем на корректность введенных данных: Не повторяется username, пароль и username минимум 1 символ, размер полей не превышает допустимые нормы, очичаем от html тегов
        $username = strip_tags($username);
        $name = strip_tags($name);
        $age = strip_tags($age);
        $about = strip_tags($about);

        $db = new mysqli("localhost", "root", "root", "homework4");
        if ($db->connect_errno) {
            exit("ошибка подключения к БД, повторите запрос");
        }

        $user_same_username = check_username($username);
        if ((!empty($user_same_username)) && ($user_same_username['id'] != $id)) {
            exit("Такой пользователь уже существует, введите другое имя");
        }
        if (empty($username) || empty($password)) {
            exit("Username и Password должны содержать минимум 1 символ");
        }
        if ((mb_strlen($username) > 100) || (mb_strlen($password) > 50) | (mb_strlen($name) > 50) || (mb_strlen($about) > 1000))
            exit("Размер введенных данных превышен <br /> Максимальный размер Username: 100, Password: 50, Name: 50, About: 1000");

        $sql = "UPDATE users SET 
            username = ?, 
             password = ?, 
            name = ?,  
            age = ?,  
            about = ?  
            WHERE id = ?";

        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param('sssisi',
                $username,
                $password,
                $name,
                $age,
                $about,
                $id);
            $stmt->execute();
        }
    }
}

class image_model {

    public function rename_photo($id_photo, $new_filename) {
        $db = new mysqli("localhost", "root", "root", 'homework4');
        if ($db->connect_errno) {
            exit("ошибка подключения к БД, повторите запрос");
        }
// Апдейтим имя файла на сервере
        $sql = "SELECT * FROM photo WHERE id = ? LIMIT  0,1";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i',
                    $id_photo);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        $stmt->close();
        rename($result['file'], $new_filename);
// Апдейтим имя фотографии в базе по заданному ID фотографии
        $sql = "UPDATE photo SET 
            file = ?   
            WHERE id = ?";

        $stmt = $db->prepare($sql);
            $stmt->bind_param('si',
                $new_filename,
                $id_photo
            );
        $stmt->execute();
        $stmt->close();

        $db->close();

    }

    public function change_avatar($user_id, $filename) {
        $db = new mysqli("localhost", "root", "root", 'homework4');
        if ($db->connect_errno) {
            exit("ошибка подключения к БД, повторите запрос");
        }
// Определяем ID изображения в базе данных
        $sql = "SELECT * FROM photo WHERE file = ? LIMIT  0,1";
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param('s',
                $filename);
            $stmt->execute();
            $image_id = $stmt->get_result();
            $image_id = $image_id->fetch_assoc();
            $stmt->close();
// Заносим ID аватарки в аккаунт к юзеру
            $sql = "UPDATE users SET 
            avatar = ? 
            WHERE id = ?";
            if ($stmt = $db->prepare($sql)) {
                $stmt->bind_param('ii',
                    $image_id['id'],
                    $user_id);
                $stmt->execute();
                $stmt->close();
            }
        }
        $db->close();
    }

    public function delete_image_from_base($filename) {
        $db = new mysqli("localhost", "root", "root", 'homework4');
        if ($db->connect_errno) {
            exit("ошибка подключения к БД, повторите запрос");
        }
        $sql = "DELETE FROM photo WHERE file = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $filename);
        $stmt->execute();
        $stmt->close();
        $db->close();
        unlink($filename);
    }

    public function add_image_to_base($user_id, $filename) {
        $db = new mysqli("localhost", "root", "root", 'homework4');
        if ($db->connect_errno) {
            exit("ошибка подключения к БД, повторите запрос");
        }
        $sql = "INSERT INTO photo (user_id, file) VALUES(?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('is', $user_id, $filename);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }

    public function upload_image_on_server($file_input, $user_id) {
        $target_dir = "photos/";
        $target_file = $target_dir . basename($file_input["fileToUpload"]["name"]);
        $uploadOk = true;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if ($target_file == $target_dir) {
            echo "Вы не выбрали файл для загрузки <br />";
        } else {
// Проверяем файл на реальное изображение или фейк
            $check = getimagesize($file_input["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
            } else {
                echo "Файл не является изображением <br />";
                $uploadOk = false;
            }
// Проверяем на существование файла на сервере
            if (file_exists($target_file)) {
                echo "Данный файл уже имеется на сервере <br />";
                $uploadOk = false;
            }
// Проверяем размер файла
            if ($file_input["fileToUpload"]["size"] > 1000000) {
                echo "Размер вашего файла слишком большой, он не может превышать 1MB <br />";
                $uploadOk = false;
            }
// Проверяем формат изображения
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                echo "Вы можете загрузить только JPG, JPEG, PNG и GIF файлы <br />";
                $uploadOk = false;
            }
// Если файл не прошел валидацию - не загружаем
            if ($uploadOk == false) {
                echo "Загрузка не выполнена по причинам указаным выше <br />";
// Если файл прошел валидаю - загружаем на сервер
            } else {
                if (move_uploaded_file($file_input["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "Файл " . basename($file_input["fileToUpload"]["name"]) . " был загружен <br />";
// Если файл успешно загрузили на сервер - заносим об этом информацию в базу
                    $this->add_image_to_base($user_id, $target_file);
                } else {
                    echo "Во время загрузки файла произошла ошибка <br />";
                }
            }
        }
    }

}