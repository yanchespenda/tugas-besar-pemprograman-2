<?php
    if (!defined('ISLOADPAGE')) {
        define('ISLOADPAGE', true);
    }
    require_once __DIR__ . '/extra/lib.php';

    use Josantonius\Session\Session;

    $isLoggin = false;

    $getUsername = "";
    $isAdmin = false;

    $getUserId = Session::get('user_id');
    if ($getUserId) {
        $isLoggin = true;
        $getUsername = Session::get('username');

        $getAdmin = Session::get('user_level');
        if ($getAdmin) {
            if ($getAdmin == 5) {
                $isAdmin = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Homepage</title>
        <?php
            include_once __DIR__ . '/resource/head.php';
            echo "<script>var runFirebaseChat = true;</script>";
        ?>
    </head>
    <body class="dark-mode">
        <div class="container">
            <div class="blog-container">
                <div class="text-center">
                    <h1 class="md-display-1">
                        Hello, welcome in chat messanger
                    </h1>
                    <?php 
                    if (!$isLoggin):
                    ?>
                    <div>
                        <p class="md-subhead universal-padding-subtext-title">Please signin or signup</p>
                    </div>
                    <?php 
                    endif;
                    ?>
                </div>
                <?php 
                if (!$isLoggin):
                ?>
                <div class="blog-list__parent layout-row layout-align-center-center">
                    <a href="/oauth/signin.php" class="md-button md-raised">Signin</a>
                    <a href="/oauth/signup.php" class="md-button md-raised">Signup</a>
                </div>
                <?php
                else:
                ?>
                <div class="chat-container">
                    <div class="md-toolbar">
                        <div class="md-toolbar-tools">
                            <div class="layout-row">
                                <h2 class="md-toolbar-item md-headline">
                                    <span><?php echo $getUsername; ?></span>
                                </h2>
                            </div>
                            <span class="flex"></span>
                            <?php
                            if ($isAdmin):
                                echo '<a href="/pbb/index.php" class="md-button md-raised">Admin</a>';
                            endif;
                            ?>
                            <a href="/oauth/signout.php" class="md-button md-raised">Signout</a>
                        </div>
                    </div>
                    <div class="chat-content">
                        <div class="chat-list-container">
                            <div class="chat-list-pre layout-column" id="chat-container">

                            </div>
                        </div>
                        <div class="chat-input-container">
                            <div class="wrap">
                                <input id="chat-input" type="text" placeholder="Write your message..." />
                                <button id="chat-tombol" class="submit">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div id="frame">
                    <div class="content">
                        <div class="messages" id="chatBox">
                            <ul id="chatBox-list">
                                
                            </ul>
                        </div>
                        <div class="message-input">
                            <div class="wrap">
                            <input id="chat_input" type="text" placeholder="Write your message..." />
                            <button id="chat_tombol" class="submit">Send</button>
                            </div>
                        </div>
                    </div>
                </div> -->
                <?php
                endif;
                ?>
            </div>
        </div>
        <?php
            include_once __DIR__ . '/resource/script.php';
        ?>
    </body>
</heml>
