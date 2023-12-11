<?php

$host = "localhost";
$db = "login_project";
$user = "root";
$password = "";
$dsn = "mysql:host=$host;dbname=$db";


try{
    $pdo = new PDO($dsn,$user,$password);
} catch (PDOException $e){
    die("Connexion échouée : ". $e->getMessage());
}


function createDB($pdo){
    if($pdo->exec("CREATE TABLE users(
        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
        email VARCHAR(255) NOT NULL,
        firstname VARCHAR(255) NOT NULL,
        lastname VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('Editor','Admin','Subscriber') NULL DEFault 'subscriber',
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP)
        ENGINE=InnoDB DEFAULT CHARSET=utf8mb4")){
            echo "Table USERS OK";
        }else{
            $pdo->errorCode();
        }
}
?>