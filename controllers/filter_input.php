<?php

require "../models/User.php";
require "../config.php";

$user = new User();
function verifySignUpInput($user,$pdo){
    $firstName = htmlspecialchars($_POST['FirstName'],ENT_QUOTES,'UTF-8');
    $lastName = htmlspecialchars($_POST['LastName'],ENT_QUOTES,'UTF-8');

    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
    }else{
        $message = "<p class='error'>L'adresse mail est invalide</p>";
        header("location:../views/signUp.php?message=$message");
    }

    $password = $_POST['password'];

    if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password)) {
        $message = "<p class='error'>Le mot de passe ne respecte pas les règles de complexité</p>";
        header("location:../views/signUp.php?message=$message");
    } else {
        $user->signUp($firstName,$lastName,$email,$password,$pdo);
    }
}

function verifyLoginInput($user,$pdo){
    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
    }else{
        $message = "<p class='error'>L'adresse mail est invalide</p>";
        header("location:../views/login.php?message=$message");
    }

    $password = $_POST['password'];
    $user->login($email,$password,$pdo);
    }



if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['SubmitSignUpForm'])){
        verifySignUpInput($user,$pdo);
    }elseif(isset($_POST['SubmitLoginForm'])){
        verifyLoginInput($user,$pdo);
    }
}



?>