<?php
session_start();

$infoMessage = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $aConfig = require_once 'config.php';
    $db = mysqli_connect(
        $aConfig['host'],
        $aConfig['user'],
        $aConfig['pass'],
        $aConfig['name']
    );

    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $query = "SELECT * FROM users WHERE email='{$_POST['email']}'";
    $dbResponse = mysqli_query($db, $query);
    $aUser = mysqli_fetch_assoc($dbResponse);

    if (!empty($aUser)) {
        $infoMessage = "Такой пользователь уже существует! Перейдите на страницу входа. ";
        $infoMessage .= "<a href='/login.php'>Страница входа</a>";
    } else {
        $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
        mysqli_query($db, $query);

        header('Location: /login.php');
        die;
    }
} elseif (!empty($_POST)) {
    $infoMessage = 'Заполните форму регистрации!';
}

?>

<!DOCTYPE html>
<html lang="">

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">

    <?php require_once 'sectionNavbar.php' ?>

    <br>

    <div class="card card-primary">
        <div class="card-header bg-success text-light">
            Register form
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <label>
                        <input class="form-control" type="email" name="email"/>
                    </label>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <label>
                        <input class="form-control" type="password" name="password"/>
                    </label>
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="formRegister"/>
                </div>
            </form>

            <?php
            if ($infoMessage) {
                echo '<hr/>';
                echo "<span style='color:red'>$infoMessage</span>";
            }
            ?>

        </div>

    </div>
</div>

</body>
</html>