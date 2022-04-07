<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="login.css">
    <title>Airbnb</title>

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


    <form action="connect.php" method="post">

        <h1>Se connecter</h1>
        <label for="email">Adresse email:</label>
        <input size="32" type="email" name="email" id="email">
        <label for="password">Mot de passe:</label>
        <input size="32" type="password" name="password" id="password">
        <input type="submit" value="Se connecter" id="submitbutton">


    </form>


    
</body>
</html>