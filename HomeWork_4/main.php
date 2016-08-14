<?php

require_once('my_class.php');
session_start();

$user_id = $_SESSION['id'];

$post_username = $_POST['Username'];
$post_password = $_POST['Password'];
$post_name = $_POST['Name'];
$post_age = $_POST['Age'];
$post_about = $_POST['About'];

#### Обрабатываем изменение данных о юзере
if ($post_username != null) {
    $user = new model_user;
    $user->change_data($user_id, $post_username, $post_password, $post_name, $post_age, $post_about);
}


#### Берем данные о юзере из сессии
$db = new mysqli("localhost", "root", "root", 'homework4');
if ($db->connect_errno) {
    exit("ошибка подключения к БД, повторите запрос");
}
$result = $db->query("select * from users where id = '$user_id' LIMIT 0,1");
$record = $result->fetch_assoc();


### Уничтожаем сессию
if (isset($_POST["Logout"])) {
    unset($_SESSION["id"]);
    session_destroy();
    echo '<script type="text/javascript">
                window.location = "index.php"
                </script>';
}


// Перенаправляем на страницу логина, если пользователь не залогинен
if (!isset($_SESSION['id'])) {
    echo '<script type="text/javascript">
                window.location = "index.php"
                </script>';
}


// Обрабатываем смену аватарки
if (isset($_POST['ChangeAvatar'])) {
    $change_avatar = new image_model();
    $change_avatar->change_avatar($user_id, "photos/" . $_POST['filename']);
}

// Определяем какая аватарка у пользователя
$result = $db->query("select * from users where id = '$user_id' ");
$avatar = $result->fetch_assoc();
$avatar_id = $avatar['avatar'];
$avatar_id = (int)$avatar_id;


$result = $db->query("select * from photo where id = '$avatar_id' ");
$avatar = $result->fetch_assoc();
$avatar = $avatar['file'];
////////

### Переименовываем изображение
if (isset($_POST["RenamePhoto"])) {
//   Вызываем функцию переименования в классе
    $rename_photo = new image_model();
    $rename_photo->rename_photo($_POST['id_photo'], "photos/" . $_POST['filename']);
}


?>

    <form action="" method="post">
        <b>Добрый день, <?php echo $record['username'] ?></b>
        <input type="submit" value="Разлогиниться" name="Logout">
    </form>

<?php

?>
    <div style="float: left">
        <form action="" method="post">
            <p>Username: <input title="" type="text" name="Username" value="<?php echo $record['username'] ?>" /></p>
            <p>Password: <input title="" type="text" name="Password" value="<?php echo $record['password'] ?>" /></p>
            <p>Name: <input title="" type="text" name="Name" value="<?php echo $record['name'] ?>" /></p>
            <p>Age: <input title="" type="number" name="Age" value="<?php echo $record['age'] ?>" /></p>
            <p>About yourself:</p>
            <p><textarea name="About" id="" cols="30" rows="10"><?php echo $record['about'] ?></textarea></p>
            <input type="submit" name="Login" value="Изменить данные" />
        </form>
        <br /><br />
        <form action="" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <p><input type="submit" value="Upload Image" name="uploadimage"></p>
        </form>
    </div>
    <div style="float: left; max-width: 300px;">
        Ваша аватарка:
        <img src="<?php echo $avatar ?>" width="100%">
    </div>


    <!-- Загружаем файл фотографии -->
<?php

if (isset($_POST["uploadimage"])) {
    $upload_image = new image_model();
    $upload_image->upload_image_on_server($_FILES, $_SESSION['id']);

}

if (isset($_POST["DeletePhoto"])) {
    $deleteimage = new image_model();
    $deleteimage->delete_image_from_base("photos/" . $_POST['filename']);
}


// Выводим доступные изображения пользователя
echo "<div style='clear: both' '> <b>Ваши загруженные изображения: </b></div>";
// Ищем изображения пользователя в таблице photo
$db = new mysqli("localhost", "root", "root", 'homework4');
if ($db->connect_errno) {
    exit("Ошибка подключения к БД, повторите запрос");
}
$result = $db->query("select * from photo where user_id = '$user_id' ");
for ($i = 0, $length = $result->num_rows; $i < $length; $i++) {
    $photo = $result->fetch_assoc();
    $photo_name = basename($photo['file']);
    ;
    ?>

    <form action="" method="post">
        <div style="max-width: 300px">
            <input type="submit" value="Выбрать аватаркой" name="ChangeAvatar">
            <input type="text" name="filename" value="<?php echo $photo_name ?>">
            <input style="display: none" type="text" name="id_photo" value="<?php echo $photo['id']?>">
            <input type="submit" value="Переименовать изображение" name="RenamePhoto">
            <input type="submit" value="Удалить изображение" name="DeletePhoto">
            <br /><br />
            <img src="<?php echo $photo['file'] ?>" width="100%">
        </div>
        <br />
    </form>

    <?php
}

