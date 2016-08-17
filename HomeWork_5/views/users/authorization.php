
<!-- * Created by PhpStorm.-->
<!-- * User: Korsic-->
<!-- * Date: 16/08/16-->
<!-- * Time: 18:24-->
<!-- */-->

<?php if (isset($errors) && is_array($errors)) : ?>
    <ul>
        <?php foreach ($errors as $error) : ?>
            <li> <?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if($login) {echo "Вы залогинены!";}?>


<h3>Авторизация на сайте</h3>

<div>
    <form action="" method="post">
        <p>Username: <input title="" type="text" name="Username_Login" value="<?php echo $username; ?>"/></p>
        <p>Password: <input title="" type="text" name="Password_Login" value="<?php echo $password; ?>"/></p>
        <input type="submit" name="Login" value="Авторизация" />
    </form>
</div>

<div>
    <form action="registration.php" method="post">
        Нет аккаунта?<input type="submit" value="Зарегистрируйтесь" />
    </form>
</div>

