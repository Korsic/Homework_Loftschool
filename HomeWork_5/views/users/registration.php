<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: Korsic-->
<!-- * Date: 16/08/16-->
<!-- * Time: 19:09-->
<!-- */-->

<h3>Регистрация на сайте</h3>

<div>
    <form action="" method="post">
        <p>Username: <input title="" type="text" name="Username_Reg" value="<?php echo $username ?>" /></p>
        <p>Password: <input title="" type="text" name="Password_Reg" value="<?php echo $password ?>" /></p>
        <p>Confirm Password: <input title="" type="text" name="ConfirmPassword"
                                    value="<?php echo $confirm_password ?>" /></p>
        <input type="submit" name="Registration" value="Регистрация" />
    </form>
</div>
<div>
    <form action="authorization.php" method="post">
        Уже зарегистрированы?<input type="submit" value="Залогиньтесь" />
    </form>
</div>



<?php if (isset($errors) && is_array($errors)) : ?>
    <ul>
        <?php foreach ($errors as $error) : ?>
            <li> <?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if($result) {echo "Вы зарегистрированы!";}?>

