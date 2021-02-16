<?php
    if (!defined('ISLOADPAGE')) {
        define('ISLOADPAGE', true);
    }
    require_once __DIR__ . '/../extra/lib.php';

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

    if (!$isAdmin) {
        echo 'Forbidden access';
        exit();
    }

    $parameterPage = false;
    if (isset($_GET['page'])) {
        $parameterPage = $_GET['page'];
    }

    $parameterAction = false;
    if (isset($_GET['action'])) {
        $parameterAction = $_GET['action'];
    }

    $parameterId = false;
    if (isset($_GET['id'])) {
        $parameterId = $_GET['id'];
    }

    $parameterSearch = false;
    if (isset($_GET['q'])) {
        $parameterSearch = $_GET['q'];
    }

    $parameterPagging = 0;
    if (isset($_GET['pi'])) {
        $parameterPagging = $_GET['pi'];
    }


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>
        <?php
            include_once __DIR__ . '/../resource/head.php';
        ?>
    </head>
    <body class="dark-mode">
        <main class="main-content flex layout-row dashboard">
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="/pbb/index.php">Dashboard</a>
                <a href="/pbb/index.php?page=filter">Filter Chat</a>
                <a href="/pbb/index.php?page=users">Users</a>
            </div>
            <div id="main-view" class="main-view">
                <md-toolbar>
                    <div class="md-toolbar-tools">
                        <a class="" href="javascript:;" onclick="openNav()">
                            Menu
                        </a>
                        <span class="flex"></span>
                        <a href="/" class="md-button md-raised">Home</a>
                        <a href="/oauth/signout.php" class="md-button md-raised">Signout</a>
                    </div>
                </md-toolbar>
                <?php
                if ($parameterPage) {
                    if ($parameterPage == "filter") {
                        if ($parameterAction == "add") {
                            include_once __DIR__ . '/components/filter/add.php';
                        } else if ($parameterAction == "edit") {
                            include_once __DIR__ . '/components/filter/edit.php';
                        } else if ($parameterAction == "save") {
                            include_once __DIR__ . '/components/filter/save.php';
                        } else if ($parameterAction == "delete") {
                            include_once __DIR__ . '/components/filter/delete.php';
                        } else {
                            include_once __DIR__ . '/components/filter/index.php';
                        }
                    } else if ($parameterPage == "users") {
                        if ($parameterAction == "add") {
                            include_once __DIR__ . '/components/user/add.php';
                        } else if ($parameterAction == "edit") {
                            include_once __DIR__ . '/components/user/edit.php';
                        } else if ($parameterAction == "save") {
                            include_once __DIR__ . '/components/user/save.php';
                        } else if ($parameterAction == "delete") {
                            include_once __DIR__ . '/components/user/delete.php';
                        } else {
                            include_once __DIR__ . '/components/user/index.php';
                        }
                    } else {
                        include_once __DIR__ . '/components/dashboard/index.php';
                    }
                } else {
                    include_once __DIR__ . '/components/dashboard/index.php';
                }
                ?>
            </div>
        </main>
        <?php
            include_once __DIR__ . '/../resource/script.php';
        ?>
    </body>
</heml>
