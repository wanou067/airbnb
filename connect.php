<?php
// ini_set('display_errors', 1);


function erreur($message){
    echo("
    <div style='width: 80%; margin: auto; border: 2px double red; text-align: center'>
    <h1 style='color: red; font-size: 2rem'>Erreur</h1>
    <h2>".$message."</h2>
    </div>
    ");
}

function success(){
    echo("
    <div style='width: 80%; margin: auto; border: 2px double green; text-align: center'>
    <h1 style='color: green; font-size: 2rem'>Connexion réussie</h1>
    <h2>Vous allez être redirigé dans quelques secondes</h2>
    </div>
    ");
}



if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        erreur("Adresse email invalide");
    }

    else {

        include_once('credentials.php');
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        try {
            $pdo = new PDO($dsn, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        $req = $pdo->prepare("SELECT password FROM client WHERE email=:email");
        $req->bindValue(":email", $email, PDO::PARAM_STR);
        if($req->execute()){
            $result = $req->fetch();

            if(!is_null($result["password"])){

                if($password == $result["password"]){
                    success();
                }
                else{
                    erreur("Mot de passe incorrect");
                }

            }
            else{
                erreur("Cette adresse email n'éxiste pas");
            }

        }
        else {
            erreur("Erreur d'éxécution");
        }
    }


}
else {
    erreur("Paramètres incorrects");
}