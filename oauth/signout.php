<?php
    if (!defined('ISLOADPAGE')) {
        define('ISLOADPAGE', true);
    }

    require_once __DIR__ . '/../extra/lib.php';

    use Josantonius\Session\Session;

    $getUserId = Session::get('user_id');
    if ($getUserId) {
        Session::destroy();

        echo 'Signout...';
        header( "refresh:2;url=/index.php" );
        exit();
    } else {
        echo 'You must logged frist';
        header( "refresh:2;url=/index.php" );
        exit();
    }

