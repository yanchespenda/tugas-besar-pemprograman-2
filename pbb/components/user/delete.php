<?php
    defined('ISLOADPAGE') OR exit('No direct script access allowed');

    require_once __DIR__ . '/../../../extra/lib.php';

    use Josantonius\Session\Session;

    $getUserId = Session::get('user_id');
    if ($getUserId == $parameterId) {
        echo 'You can not delete your self';
        header( "refresh:2;url=/pbb/index.php?page=users" );
        exit();
    }

    $stmt = $conn->prepare("SELECT count(id) as jumlah FROM users WHERE id = :id LIMIT 1"); 
    $stmt->bindParam(':id', $parameterId, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row) {
        if ($row['jumlah'] == 1) {
            $stmt = $conn->prepare("DELETE FROM users WHERE id == :id"); 
            $stmt->bindParam(':id', $parameterId, PDO::PARAM_INT);
            $stmt->execute();

            echo 'Data delete';
            header( "refresh:2;url=/pbb/index.php?page=users" );
            exit();
        } else {
            echo 'Data not found';
            header( "refresh:2;url=/pbb/index.php?page=users" );
            exit();
        }
    } else {
        echo 'Data not found';
        header( "refresh:2;url=/pbb/index.php?page=users" );
        exit();
    }