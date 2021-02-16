<?php
    defined('ISLOADPAGE') OR exit('No direct script access allowed');

    require_once __DIR__ . '/../../../extra/lib.php';

    use Josantonius\Session\Session;
    use Wruczek\PhpFileCache\PhpFileCache;

    $stmt = $conn->prepare("SELECT count(id) as jumlah FROM chat_filter WHERE id = :id LIMIT 1"); 
    $stmt->bindParam(':id', $parameterId, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row) {
        if ($row['jumlah'] == 1) {
            $stmt = $conn->prepare("DELETE FROM chat_filter WHERE id == :id"); 
            $stmt->bindParam(':id', $parameterId, PDO::PARAM_INT);
            $stmt->execute();

            $cache = new PhpFileCache(__DIR__ . '/../../../api/cache/');
            $cache->eraseKey("chat-filter");

            echo 'Data delete';
            header( "refresh:2;url=/pbb/index.php?page=filter" );
            exit();
        } else {
            echo 'Data not found';
            header( "refresh:2;url=/pbb/index.php?page=filter" );
            exit();
        }
    } else {
        echo 'Data not found';
        header( "refresh:2;url=/pbb/index.php?page=filter" );
        exit();
    }