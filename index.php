<?php 
  include_once("controller/index.php");
?>

<!DOCTYPE html>
<html lang="es-ES">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main.css">
  <title>Mis Links Favoritos | login</title>
</head>

<body>
<main>
  <?php
    if($_SESSION["auth"]){
      if($_SESSION["isAdmin"])
        include_once("components/section_admin.php");
      else 
        include_once("components/section_users.php");
    } elseif(!$baneado) {
      include_once("components/form_login.php");
    } else {
      include_once("components/section_ban.php");
    }   
  ?>
  </main>
</body>

</html>