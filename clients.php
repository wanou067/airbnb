<?php
   include_once("./cacheclear.php");
   include_once("./functions.php");



    function operationfailed($operation, $error) {
        $errmessage = $error[2];
        print_r($error);
        switch($operation){
            case "insertion":
                echo("
                <div style=\"border: 1px double red; color: red; width: 50%; margin: auto; text-align: center; margin-top: 2rem\">
                    <h1>Echec de l'insertion</h1>
                    <h2>".$errmessage."</h2>
                </div>
                ");
                break;
            case "supression":
                echo("
                <div style=\"border: 1px double red; color: red; width: 50%; margin: auto; text-align: center; margin-top: 2rem\">
                    <h1>Echec de la supression</h1>
                    <h2>".$errmessage."</h2>
                </div>
                ");
                break;
            default:
            echo("
            <div style=\"border: 1px double red; color: red; width: 50%; margin: auto; text-align: center; margin-top: 2rem\">
                <h1>Erreur de nature inconue</h1>
                <h2>".$errmessage."</h2>
            </div>
            ");
            break;
        }
    }

    function operationsuccess($operation, $id) {
        switch($operation){
            case "insertion":
                echo("
                    <div style=\"border: 1px double green; color: green; width: 50%; margin: auto; text-align: center; margin-top: 2rem\">
                        <h1>Insertion réussie</h1>
                        <h2>Le client ".$id." a été créé</h2>
                    </div>
                    ");
                break;
            
            case "supression":
                echo("
                    <div style=\"border: 1px double green; color: green; width: 50%; margin: auto; text-align: center; margin-top: 2rem\">
                        <h1>Suppression réussie</h1>
                        <h2>Le client d'id ".$id." a été supprimé</h2>
                    </div>
                    ");
                break;
                
        }
    }

    include_once('credentials.php');
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        try {
            $pdo = new PDO($dsn, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
       }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="index.css">
    <title>Airbnb</title>
    <script src="https://kit.fontawesome.com/d9d35e79f6.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">

</head>
<body>

    <header>


    <nav>
            <ul>
                <a href="index.html" id="logo"><img src="img/logo.png" alt=""></a>
                <a href="clients.php?action=afficher">Clients</a>
                <a href="clients.php?action=Inserer">Insérer</a>
                <a href="index.html">Rien</a>
                <a href="login.php">Login</a>
            </ul>
        </nav>

    </header>

<?php

if(isset($_GET['action'])){
    $action = $_GET['action'];
} else {
    $action = "None";
}

if($action == "afficher"){

    if(isset($_GET['subaction']) && $_GET['subaction'] == "supprimer" && isset($_GET['id'])){

        $stmt = $pdo->prepare('DELETE FROM client WHERE id=:id');
        $id = $_GET['id'];
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            operationsuccess("supression",$id);
        }  else {
            operationfailed("supression","Erreur de supression");
        }

    }

    ?>
    <table>
        <tr>
            <th>id</th>
            <th>Hote</th>
            <th>Prenom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        <?php
        

       $stmt = $pdo->query('SELECT * FROM client');
        while ($row = $stmt->fetch())
        {
            echo('<tr style="height:4vh;">');
            
            echo("<td>".$row['id']."</td>");

            if($row['hote'] == 1){
                echo('<td><i style="color: green" class="fa-solid fa-check fa-xl"></i></td>');
            }
            else{
                echo('<td><i style="color: red" class="fa-solid fa-xmark fa-xl"></i></td>');
            }
            echo("<td>".$row['prenom']."</td>");
            echo("<td>".$row['nom']."</td>");
            echo("<td>".$row['email']."</td>");
            echo("<td>".$row['adresse']."</td>");
            echo('<td><a href="clients.php?action=modifier&id='.$row['id'].'"><i style="color: blue" class="fa-solid fa-pen-to-square fa-xl"></i></a></td>');
            echo('<td style="width=2rem;"><a href="clients.php?action=afficher&subaction=supprimer&id='.$row['id'].'"><i style="color: red" class="fa-solid fa-xmark fa-xl"></i></a></td>');

            echo("</tr>");
        }

        ?>
    </table>

<?php
}

else if($action == "Inserer" || $action == "modifier") {


    if(isset($_GET['justinsert']) && $_GET['justinsert'] == true){
        
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $adresse = $_POST['adresse'];
        $hote = $_POST['hote'];

        if(is_null($nom) || is_null($prenom) || is_null($tel) || is_null($email) || is_null($password) || is_null($adresse)){
            erreurform("Veuillez remplir tous les champs obligatoires");
        }
        else{

            if(strlen($nom) > 40){
                erreurform("Le nom est trop long !");
            }
            else if(strlen($prenom) > 30){
                erreurform("Le prenom est trop long !");
            }
            else if(strlen($nom) > 12){
                erreurform("Le numéro de téléphone fourni est incorrect");
            }
            else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                erreurform("L'adresse email fournie est invalide");
            }
            else if(strlen($password) > 40){
                erreurform("Votre mot de passe ne respecte pas les critères");
            }
            
            else {

                if(is_null($hote)){
                    $hote = false;
                } else {
                    $hote = true;
                }
    
                if($action == "Inserer"){

                    $stmt = $pdo->prepare('INSERT INTO client (nom, prenom, tel, email, password, adresse, hote) VALUES (:nom, :prenom, :tel, :email, :passwords, :adresse, :hote)');

                } else {

                    $stmt = $pdo->prepare('UPDATE client SET nom = :nom, prenom = :prenom, tel = :tel, 
                        email = :email, password = :passwords, adresse = :adresse, hote = :hote WHERE id=:id');
                    $stmt->bindValue(":id", $_POST['id'], PDO::PARAM_INT);

                }
                $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
                $stmt->bindValue(":prenom", $prenom, PDO::PARAM_STR);
                $stmt->bindValue(":tel", $tel, PDO::PARAM_STR);
                $stmt->bindValue(":email", $email, PDO::PARAM_STR);
                $stmt->bindValue(":passwords", $password, PDO::PARAM_STR);
                $stmt->bindValue(":adresse", $adresse, PDO::PARAM_STR);
                $stmt->bindValue(":hote", $hote, PDO::PARAM_BOOL);
    
                try {
                    $stmt->execute();
                } catch (PDOException $th) {
                    echo "--:".$th; 
                }

                if(!$stmt->execute()){
                    $erreursql = $stmt->errorInfo();
                    //erreurform("Erreur inconnue");
                    operationfailed("insertion",$erreursql);
                    print_r($erreursql);
                }else {
                    operationsuccess("insertion", $prenom);
                }
                


            }
 
        }

    }


    if($action == "modifier") {

        $stmt = $pdo->prepare('SELECT nom, prenom, tel, email, adresse, hote FROM client WHERE id=:id');
        $stmt->bindValue(":id", $_GET['id'], PDO::PARAM_INT);
        if(!$stmt->execute()){
            $erreursql = $stmt->errorInfo();
            operationfailed("insertion",$erreursql);
        } else {
            $result = $stmt->fetch();
            if($result["hote"] == 1){
                $hote = "checked";
            } else {
                $hote = "";
            }
            echo('

            <form class="forminsert" action="clients.php?action=modifier&justinsert=true" method="post">
            <h1>Modifier un client</h1>

            <label for="nom">Nom</label>
            <input value="'.$result["nom"].'" required type="text" name="nom" id="nom"><br>
            <label for="nom">Prénom</label>
            <input value="'.$result["prenom"].'" required type="text" name="prenom" id="prenom"><br>
            <label for="tel">Téléphone</label>
            <input value="'.$result["tel"].'" required type="tel" name="tel" id="tel"><br>
            <label for="email">Email</label>
            <input value="'.$result["email"].'" required type="email" name="email" id="email"><br>
            <label for="password">Mot de passe</label>
            <input value='.$result["password"].' required type="password" name="password" id="password"><br>
            <label for="adresse">Adresse</label>
            <input size="40" value="'.$result["adresse"].'" required type="text" name="adresse" id="adresse"><br>
            <label for="hote">Hote ?</label>
            <input type="checkbox" name="hote" id="hote" '.$hote.'><br>
            <input type="hidden" value="'.$_GET['id'].'" name="id">
            <input type="submit">
            </form>
            ');
        }

    } else {

        echo('

        <form class="forminsert" action="clients.php?action=Inserer&justinsert=true" method="post">
        <h1>Insérer un client</h1>

        <label for="nom">Nom</label>
        <input required type="text" name="nom" id="nom"><br>
        <label for="nom">Prénom</label>
        <input required type="text" name="prenom" id="prenom"><br>
        <label for="tel">Téléphone</label>
        <input required type="tel" name="tel" id="tel"><br>
        <label for="email">Email</label>
        <input required type="email" name="email" id="email"><br>
        <label for="password">Mot de passe</label>
        <input required type="password" name="password" id="password"><br>
        <label for="adresse">Adresse</label>
        <input required type="text" name="adresse" id="adresse"><br>
        <label for="hote">Hote ?</label>
        <input type="checkbox" name="hote" id="hote"><br>
            
        <input type="submit">
        </form>

        ');
    }

}



else{
    ?>
    <p><a href="clients.php?action=afficher">Afficher la liste des clients</a></p>
    <p><a href="clients.php?action=Inserer">Insérer un client</a></p>
    <?php
}


?>
    





    
</body>
</html>