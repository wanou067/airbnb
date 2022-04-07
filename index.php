<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
    <title>Airbnb</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">

</head>
<body>
<?php
ini_set('display_errors', 1);
include_once('credentials.php');
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>


    <header>


        <nav>
            <ul>
                <a href="index.html" id="logo"><img src="img/logo.png" alt=""></a>
                <a href="clients.php?action=afficher">Clients</a>
                <a href="clients.php?action=Inserer">Insérer</a>
                <a href="index.html">Rien</a>
                <?php
                session_start();
                if(isset($_SESSION['user_id'])) {
                    $req = $pdo->prepare("SELECT prenom, nom FROM client WHERE id=:id");
                    $req->bindValue(":id", $_SESSION['user_id']);
                    if($req->execute()){
                        $result = $req->fetch();
                        if(isset($result["prenom"])){
                            echo('<a id="logout" href="logout.php"><span style="line-height: 40px;">Bonjour '.$result["prenom"].'</span><br>
                            <span style="color: red; text-decoration: underline">Se déconnecter</span></a>');
                        }
                        else{
                            echo('<a id="login" href="login.php">Login</a>');
                        }
                        
                    } else {
                        echo('<a id="login" href="login.php">Login</a>');
                    }
                } else {
                    echo('<a id="login" href="login.php">Login</a>');
                }

                ?>
            </ul>
        </nav>

    </header>


    
</body>
</html>