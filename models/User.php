<?php
session_start();
class User{

    public function __construct() {}

    public function signUp($firstName,$lastName,$email,$password,$pdo){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (firstname,lastname,email,password) VALUES (?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $firstName, PDO::PARAM_STR);
        $stmt->bindValue(2, $lastName, PDO::PARAM_STR);
        $stmt->bindValue(3, $email, PDO::PARAM_STR);
        $stmt->bindValue(4, $hashedPassword, PDO::PARAM_STR);
        if($stmt->execute()){
            //echo "User correctement creer";
            header("location:../views/login.php");
        }else{
            echo "erreur lors de la creation".$pdo->error;
        }

    }


    public function login($email, $password, $pdo) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $email, PDO::PARAM_STR);
    
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                echo "Cet utilisateur existe";
    
                $hashedPasswordFromDatabase = $row['password'];
                if (password_verify($password, $hashedPasswordFromDatabase)) {
                    echo "Mot de passe correct. Authentification réussie.";
                    $_SESSION['user_data'] = array(
                        'id' => $row['id'],
                        'email' => $row['email'],
                        'firstname' => $row['firstname'],
                        'role' => $row['role']
                    );

                    //var_dump($_SESSION['user_data']);
                } else {
                    echo "Mot de passe incorrect. Authentification échouée.";
                }
            } else {
                echo "Aucun utilisateur trouvé";
            }
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $stmt->errorInfo()[2];
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