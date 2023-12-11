<?php

require "../models/User.php";
require "../config.php";

$user = new User();
function verifySignInInput($user,$pdo){
    $firstName = htmlspecialchars($_POST['FirstName'],ENT_QUOTES,'UTF-8');
    $lastName = htmlspecialchars($_POST['LastName'],ENT_QUOTES,'UTF-8');

    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
    }else{
        echo "L'adresse mail est invalide";
    }

    $password = $_POST['password'];

    if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password)) {
        echo "Le mot de passe ne respecte pas les règles de complexité";
    } else {
        $user->signIn($firstName,$lastName,$email,$password,$pdo);
    }
}

function verifyLoginInput($user,$pdo){
    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
    }else{
        echo "L'adresse mail est invalide";
    }

    $password = $_POST['password'];
    $user->login($email,$password,$pdo);
    }



if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['SubmitSignInForm'])){
        verifySignInInput($user,$pdo);
    }elseif(isset($_POST['SubmitLoginForm'])){
        verifyLoginInput($user,$pdo);
    }
}



?>