<?php include_once ("logout.php")?>


<!-- * Created by PhpStorm.-->
<!-- * User: Korsic-->
<!-- * Date: 16/08/16-->
<!-- * Time: 18:27-->


<h3>Просмотр файлов загруженных пользователем</h3>

Количество загруженных вами файлов: <?php echo $count_files . "<br />";
foreach ($files as $filename) {
    echo "<p>" . $filename['file'] . "<p/>";
}

if (isset($avatar)) {
    echo "Ваша аватарка: <img src = $avatar >";
} else {
    echo "<p>У вас не выбран аватар</p>";
}

?>
<div style="margin-top: 50px;">
    <form action="index.php" method="post">
        <input type="submit" value="Просмотреть список пользователей на сайте" />
    </form>
</div>