<?php
session_start();
class User{

    public function __construct() {}

    public function signUp($firstName,$lastName,$email,$password,$pdo){
        $sql = "SELECT id FROM users WHERE email=?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1,$email,PDO::PARAM_STR);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $message = "<p class='error'>Cette adresse mail existe deja</p>";
                header("location:../views/signUp.php?message=$message");
            }else{
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (firstname,lastname,email,password) VALUES (?,?,?,?)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, $firstName, PDO::PARAM_STR);
                $stmt->bindValue(2, $lastName, PDO::PARAM_STR);
                $stmt->bindValue(3, $email, PDO::PARAM_STR);
                $stmt->bindValue(4, $hashedPassword, PDO::PARAM_STR);
                if($stmt->execute()){
                    echo "";
                    $message = "<p class='success'>Votre compte a etait creer</p>";
                    header("location:../views/login.php?message=$message");
                }else{
                    $message = "<p class='error'>Une erreur est survenue lors de la creation de votre compte</p>";
                    header("location:../views/lsignup.php?message=$message");
                }
            }
        }else{
            echo $pdo->error;
        }
    }


    public function login($email, $password, $pdo) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $email, PDO::PARAM_STR);
    
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                $hashedPasswordFromDatabase = $row['password'];
                if (password_verify($password, $hashedPasswordFromDatabase)) {
                    $_SESSION['user_data'] = array(
                        'id' => $row['id'],
                        'email' => $row['email'],
                        'firstname' => $row['firstname'],
                        'role' => $row['role']
                    );
                    $message = "<p class='success'>Bienvenue".$_SESSION['user_data']['firstname']."</p>";
                    header("location:../views/index.php?message=$message");
                    //var_dump($_SESSION['user_data']);
                } else {
                    $message = "<p class='error'>Mot de passe incorrect. Authentification échouée.</p>";
                    header("location:../views/login.php?message=$message");
                }
            } else {
                $message = "<p class='error'>Aucun utilisateur trouvé</p>";
                header("location:../views/login.php?message=$message");
            }
        } else {
            $message = "<p class='error'>Une erreur est survenue</p>";
                header("location:../views/login.php?message=$message");
        }
    }
    
    public function verifyRole($user_data){
        //user_data fait reference a notre session['user_data']
        // Ajouter vos condition en fonction de chaque role
        if($user_data['role'] == 'Admin'){
            echo "Welcome Admin";
        }elseif($user_data['role'] == 'Editor'){
            echo "Welcome Editor";
        }elseif($user_data['role'] == 'Subscriber'){
            echo "Welcome Subscriber";
        }
    }

}

?>