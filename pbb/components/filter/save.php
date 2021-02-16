<?php
    defined('ISLOADPAGE') OR exit('No direct script access allowed');

    require_once __DIR__ . '/../../../extra/lib.php';

    use Josantonius\Session\Session;
    use Wruczek\PhpFileCache\PhpFileCache;

    if (isset($_POST['submit'])) {
        $getId = (isset($_POST['id']))?(int) $_POST['id']:false;
        $getKata = (isset($_POST['kata']))?strtolower($_POST['kata']):false;
        if ($getKata) {
            $isUpdate = false;
            if ($getId) {
                $isUpdate = true;
            }

            if (!$isUpdate) {
                $stmt = $conn->prepare("SELECT count(id) as jumlah FROM chat_filter WHERE kata = :kata LIMIT 1"); 
                $stmt->bindParam(':kata', $getKata);
                $stmt->execute();
                $row = $stmt->fetch();
    
                if ($row) {
                    if ($row['jumlah'] == 0) {
                        $stmt = $conn->prepare("INSERT INTO chat_filter VALUES (null, :kata, null)"); 
                        $stmt->bindParam(':kata', $getKata);
                        $stmt->execute();

                        $cache = new PhpFileCache(__DIR__ . '/../../../api/cache/');
                        $cache->eraseKey("chat-filter");
    
                        echo 'Filter saved';
                        header( "refresh:2;url=/pbb/index.php?page=filter" );
                        exit();
                    } else {
                        echo 'Filter already exits';
                        header( "refresh:2;url=/pbb/index.php?page=filter&action=add" );
                        exit();
                    }
                }
            } else {
                $stmt = $conn->prepare("SELECT count(id) as jumlah FROM chat_filter WHERE kata = :kata AND id != :id LIMIT 1"); 
                $stmt->bindParam(':kata', $getKata);
                $stmt->bindParam(':id', $getId, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch();

                if ($row) {
                    if ($row['jumlah'] == 0) {
                        $stmt = $conn->prepare("UPDATE chat_filter SET kata = :kata WHERE id = :id"); 
                        $stmt->bindParam(':kata', $getKata);
                        $stmt->bindParam(':id', $getId, PDO::PARAM_INT);
                        $stmt->execute();

                        echo 'Filter saved';
                        header( "refresh:2;url=/pbb/index.php?page=filter" );
                        exit();
                    } else {
                        echo 'Filter already exits';
                        header( "refresh:2;url=/pbb/index.php?page=filter&action=add" );
                        exit();
                    }
                }
            }
        }
    }
    echo 'Something not valid';
    header( "refresh:2;url=/pbb/index.php?page=filter&action=add" );
    exit();
