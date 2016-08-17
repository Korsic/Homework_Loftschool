<?php include_once ('logout.php') ?>

<h3>Список пользователей на сайте отсортированных по возрасту:</h3>

<?php

echo '<table border="1">'; ?>
<tr>
    <td>
        <b>ID</b>
    </td>
    <td>
        <b>Username</b>
    </td>
    <td>
        <b>Имя</b>
    </td>
    <td>
        <b>Возраст</b>
    </td>
    <td>
        <b>Описание</b>
    </td>
    <td>
        <b>Совершеннолетность</b>
    </td>
</tr>
<?php
foreach ($usersList as $user) {
    echo '<tr>';
    foreach ($user as $value) {
        echo '<td>' . $value . "</td>";
    }
    if ($user['age'] >= 18) {
        echo '<td>Совершеннолетний </td>';
    } else {
        echo '<td>Не совершеннолетний </td>';

    }
    echo "</tr>";
} ?>

</table>

<div style="margin-top: 20px;">
    <form action="files.php" method="post">
        <input type="submit" value="Файлы загруженные вами" />
    </form>
</div>

