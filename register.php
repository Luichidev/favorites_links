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
  <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
  <title>Mis links favoritos | Registro</title>
</head>

<body>
  <main>
    <section class="flex-container login">
      <div class="form-container">
        <h1>MIS LINKS FAVORITOS</h1>
        <h2>Registro</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" autocomplete="off">
          <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name" value="<?php echo $name;?>">
          </div>
          <div class="form-group">
            <label for="email">Correo:</label>
            <input type="text" placeholder="ejemplo@ejemplo.com" name="email" value="<?php echo $email;?>">
          </div>
          <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password">
          </div>
          <div class="btn-group">
            <button class="btn success" name="sendRegister">registrar</button>
          </div>
          <div class="form-group">
            <?= !empty($err)? $err : "" ?>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>

</html>