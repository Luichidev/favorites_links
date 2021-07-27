<section class="container">
  <h1>PANEL DE ADMINISTRADOR</h1>
  <a href="<?php echo $_SERVER["PHP_SELF"], "?logout"?>" class="btn success">Logout</a>
  <p>Bienvenido <?php echo $_SESSION["name"];?></p>

  <table class="table">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Nro de Links</th>
      </tr>
    </thead>
    <tbody>
    <?= drawTable($_SESSION["data"]) ?>
    </tbody>
  </table>
</section>