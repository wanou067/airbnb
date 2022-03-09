<?php
   include_once("./cacheclear.php");
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
    ?>
    <form class="forminsert" action="" method="post">
    <h1>Insérer un client</h1>

    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom"><br>
    <label for="nom">Prénom</label>
    <input type="text" name="prenom" id="prenom"><br>
    <label for="tel">Téléphone</label>
    <input type="tel" name="tel" id="tel"><br>
    <label for="email">Email</label>
    <input type="email" name="email" id="email"><br>
    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password"><br>
    <label for="adresse">Adresse</label>
    <input type="text" name="adresse" id="adresse"><br>
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