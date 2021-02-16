<?php
    if (!defined('ISLOADPAGE')) {
        define('ISLOADPAGE', true);
    }
    require_once __DIR__ . '/../extra/lib.php';

    use Josantonius\Session\Session;
    use MiladRahimi\Jwt\Generator;
    use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;

    $getUserId = Session::get('user_id');
    if ($getUserId) {
        echo 'You already logged';
        header( "refresh:2;url=/index.php" );
        exit();
    }

    $isSuccess = false;
    $isError = false;

    if (isset($_POST['submit'])) {
        if ($conn) {
            $getEmail = (isset($_POST['email']))?$_POST['email']:false;
            $getPassword = (isset($_POST['password']))?$_POST['password']:false;

            if ($getEmail && $getPassword) {
                $stmt = $conn->prepare("SELECT `id`, `username`, `email`, `password`, `role` FROM users WHERE email = :email LIMIT 1"); 
                $stmt->bindParam(':email', $getEmail);
                $stmt->execute();
                $row = $stmt->fetch();

                if ($row) {
                    if (password_verify($getPassword, $row['password'])) {
                        Session::set('user_id', $row['id']);
                        Session::set('username', $row['username']);
                        Session::set('user_level', $row['role']);

                        $jwt = generateCustomToken($row['id'], $row['role']);
                        Session::set('user_token', $jwt);

                        $isSuccess = true;

                        echo 'Signin success';
                        header( "refresh:2;url=/index.php" );
                        exit();
                    } else {
                        $isError = true;
                    }
                } else {
                    $isError = true;
                }
            } else {
                $isError = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Signin</title>
        <?php
            include_once __DIR__ . '/../resource/head.php';
        ?>
    </head>
    <body class="dark-mode">
        <div class="container">
            <form class="oauth" method="POST" action="/oauth/signin.php">
                <h1>Signin</h1>
                <?php
                if ($isSuccess):
                    echo '<h5>Signin success</h5>';
                endif;
                if ($isError):
                    echo '<h5 class="error-text">Email or password does not match</h5>';
                endif;
                ?>
                <div class="group">
                    <input type="text" name="email" required="required"/>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Email</label>
                </div>
                <div class="group">
                    <input type="password" name="password" required="required"/>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Password</label>
                </div>
                <div class="btn-box">
                    <button class="btn btn-submit" name="submit" value="submit" type="submit">submit</button>
                </div>
            </form>
        </div>
        <?php
            include_once __DIR__ . '/../resource/script.php';
        ?>
    </body>
</heml>
