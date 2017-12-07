<?php
    session_start();
    require_once 'config/database.php';
    require 'functions/pdo.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        $pdo = connect_pdo();

        $req = $pdo->prepare("SELECT * FROM users WHERE username=:username");
        $req->execute(array(':username' => $username));
        $user = $req->fetch();
        $req->closeCursor();

        if (!$user) {
            header("Location: index.php?msglogerror");
        }
        if (password_verify($password, $user['password'])){
            if ($user['verified'] == 'O') {
                $_SESSION['signup_success'] = true;
                $_SESSION['user'] = $user;
                header("Location: index.php");
            }
            else {
                header("Location: index.php?msglogverified");
            }
        }
        else {
            header("Location: index.php?msglogerror");
        }
    }
    catch (PDOException $e) {
        echo "ERROR LOGIN" . $e->getMessage();
    }
?>