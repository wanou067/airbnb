

<div style='width: 80%; margin: auto; border: 2px double green; text-align: center'>
    <h1 style='color: green; font-size: 2rem'>Déconnexion réussie</h1>
    <h2>Vous allez être redirigé dans quelques secondes</h2>
</div>
<?php
session_start();
session_destroy();
?>
<script type="text/javascript">
      function RedirectionJavascript(){
        document.location.href="index.php";
      }
      setTimeout('RedirectionJavascript()', 3000)
</script>