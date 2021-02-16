<?php
    if (!defined('ISLOADPAGE')) {
        define('ISLOADPAGE', true);
    }
    require_once __DIR__ . '/../extra/lib.php';

    use Josantonius\Session\Session;

    $getUserId = Session::get('user_id');
    if ($getUserId) {
        echo 'You already logged';
        header( "refresh:2;url=/index.php" );
        exit();
    }

    $isSuccess = false;
    $isError = false;
    $errorMessage = "";

    if (isset($_POST['submit'])) {
        if ($conn) {
            $getEmail = (isset($_POST['email']))?$_POST['email']:false;
            $getUsername = (isset($_POST['username']))?$_POST['username']:false;
            $getPassword = (isset($_POST['password']))?$_POST['password']:false;

            $getUsername = preg_replace("/[^a-zA-Z0-9]+/", "", $getUsername);

            if ($getEmail && $getUsername && $getPassword) {
                $stmt = $conn->prepare("SELECT count(id) as jumlah FROM users WHERE username = :username OR email = :email LIMIT 1"); 
                $stmt->bindParam(':username', $getUsername);
                $stmt->bindParam(':email', $getEmail);
                $stmt->execute();
                $row = $stmt->fetch();

                if ($row) {
                    if ($row['jumlah'] == 0) {
                        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :pass)");
                        $setPassword = password_hash($getPassword, PASSWORD_BCRYPT);
                        $stmt->bindParam(':username', $getUsername);
                        $stmt->bindParam(':email', $getEmail);
                        $stmt->bindParam(':pass', $setPassword);
                        $stmt->execute();

                        echo 'Registration success';
                        header( "refresh:2;url=/index.php" );
                        exit();

                        $isSuccess = true;
                    } else {
                        $errorMessage = "Email or Username has used";
                        $isError = true;
                    }
                } else {
                    $errorMessage = "Email or Username has used";
                    $isError = true;
                }
            } else {
                $errorMessage = "Data not valid";
                $isError = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
        <?php
            include_once __DIR__ . '/../resource/head.php';
        ?>
    </head>
    <body class="dark-mode">
        <div class="container">
            <form class="oauth" method="POST" action="/oauth/signup.php">
                <h1>Signup</h1>
                <?php
                if ($isSuccess):
                    echo '<h5>Registration success</h5>';
                endif;
                if ($isError):
                    echo '<h5 class="error-text">' . $errorMessage . '</h5>';
                endif;
                ?>
                <div class="group">
                    <input type="email" name="email" required="required" />
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Email</label>
                </div>
                <div class="group">
                    <input type="text" name="username" required="required" />
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Username</label>
                </div>
                <div class="group">
                    <input type="password" name="password" required="required" />
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Password</label>
                </div>
                <div class="btn-box">
                    <button class="btn btn-submit" name="submit" value="submit" type="submit">Signup</button>
                </div>
            </form>
        </div>
        <?php
            include_once __DIR__ . '/../resource/script.php';
        ?>
    </body>
</heml>
