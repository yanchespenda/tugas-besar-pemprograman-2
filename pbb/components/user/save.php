<?php
    defined('ISLOADPAGE') OR exit('No direct script access allowed');

    require_once __DIR__ . '/../../../extra/lib.php';

    use Josantonius\Session\Session;

    if (isset($_POST['submit'])) {
        $getId = (isset($_POST['id']))?(int) $_POST['id']:false;
        $getUsername = (isset($_POST['username']))?strtolower($_POST['username']):false;
        $getEmail = (isset($_POST['email']))?strtolower($_POST['email']):false;
        $getPassword = (isset($_POST['password']))?strtolower($_POST['password']):false;
        if ($getUsername && $getEmail) {
            $isUpdate = false;
            if ($getId) {
                $isUpdate = true;
            }

            $getUsername = preg_replace("/[^a-zA-Z0-9]+/", "", $getUsername);

            if (!$isUpdate) {
                if (!$getPassword) {
                    echo 'Something not valid';
                    header( "refresh:2;url=/pbb/index.php?page=users&action=add" );
                    exit();
                }
                $stmt = $conn->prepare("SELECT count(id) as jumlah FROM users WHERE username = :username OR email = :email LIMIT 1"); 
                $stmt->bindParam(':username', $getUsername);
                $stmt->bindParam(':email', $getEmail);
                $stmt->execute();
                $row = $stmt->fetch();
    
                if ($row) {
                    if ($row['jumlah'] == 0) {
                        $stmt = $conn->prepare("INSERT INTO users VALUES (null, :username, :email, :password, 1)");
                        $setPassword = password_hash($getPassword, PASSWORD_BCRYPT);
                        $stmt->bindParam(':username', $getUsername);
                        $stmt->bindParam(':email', $getEmail);
                        $stmt->bindParam(':password', $setPassword);
                        $stmt->execute();
    
                        echo 'User saved';
                        header( "refresh:2;url=/pbb/index.php?page=users" );
                        exit();
                    } else {
                        echo 'User already exits';
                        header( "refresh:2;url=/pbb/index.php?page=users&action=add" );
                        exit();
                    }
                }
            } else {
                $stmt = $conn->prepare("SELECT count(id) as jumlah FROM users WHERE (username = :username OR email = :email) AND id != :id LIMIT 1"); 
                $stmt->bindParam(':username', $getUsername);
                $stmt->bindParam(':email', $getEmail);
                $stmt->bindParam(':id', $getId, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch();

                if ($row) {
                    if ($row['jumlah'] == 0) {
                        if ($getPassword) {
                            $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id"); 
                            $setPassword = password_hash($getPassword, PASSWORD_BCRYPT);
                            $stmt->bindParam(':password', $setPassword);
                        } else {
                            $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id"); 
                        }
                        $stmt->bindParam(':username', $getUsername);
                        $stmt->bindParam(':email', $getEmail);
                        $stmt->bindParam(':id', $getId, PDO::PARAM_INT);
                        $stmt->execute();

                        echo 'User saved';
                        header( "refresh:2;url=/pbb/index.php?page=users" );
                        exit();
                    } else {
                        echo 'User already exits';
                        header( "refresh:2;url=/pbb/index.php?page=users&action=add" );
                        exit();
                    }
                }
            }
        }
    }
    echo 'Something not valid';
    header( "refresh:2;url=/pbb/index.php?page=users&action=add" );
    exit();
