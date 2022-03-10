<?php
   include_once("./cacheclear.php");

   function erreurform($error) {
    echo("
        <div style=\"border: 1px double red; color: red; width: 50%; margin: auto; text-align: center\">
            <h1>Echec de l'insertion</h1>
            <h2>".$error."</h2>
        </div>
        ");
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
                <a href="clients.php">Clients</a>
                <a href="index.html">Insérer</a>
                <a href="index.html">Supprimer</a>
                <a href="index.html">Modifier</a>
            </ul>
        </nav>

    </header>

<?php

$action = $_GET['action'];

if($action == "afficher"){
    ?>
    <h1>Liste des clients:</h1>
    <table>
        <tr>
            <th>id</th>
            <th>Hote</th>
            <th>Prenom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Supprimer</th>
        </tr>
        <?php
        include_once('credentials.php');
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
       } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
       }

       $stmt = $pdo->query('SELECT * FROM client');
        while ($row = $stmt->fetch())
        {
            echo("<tr>");
            
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
            echo('<td><i style="color: red" class="fa-solid fa-xmark fa-xl"></i></td>');

            echo("</tr>");
        }

        ?>
    </table>

<?php
}

else if($action == "Inserer") {

$justinstert = $_GET['justinsert'];

    if($justinstert == true){
        
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
                erreurform("Le nom est trop long !")
            }
            if(strlen($prenom) > 30){
                erreurform("Le prenom est trop long !")
            }
            if(is_numeric($nom) > 40){
                erreurform("Le numéro de téléphone fourni est incorrect")
            }




            include_once('credentials.php');
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            try {
                $pdo = new PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                    throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }

            $stmt = $pdo->query('INSERT INTO client ("nom", "prenom", "tel", "email", "password", "adresse", "hote") VALUES (:nom, :prenom, :tel, :email, :password, :adresse, :hote');

        }
            }


    ?>
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

<?php
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