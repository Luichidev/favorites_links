<section class="container">
  <a href="<?php echo $_SERVER["PHP_SELF"], "?logout"?>" class="btn success">Logout</a>
  <h1>Mis links favoritos</h1>
  <p>Bienvenido <?php echo $_SESSION["name"];?></p>
  <form id="form-send" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
    <div class="flex-container">
      <div class="form-group flex-1">
        <label>Titulo</label><input type="text" name="title">
      </div>
      <div class="form-group flex-1">
        <label>Url</label><input type="text" name="url">
      </div>
      <div class="form-group flex-1">
        <label>Descripción</label><input type="text" name="description">
      </div>
      <div class="form-group">
        <label>Link publico</label><input type="checkbox" checked name="esPublico">
      </div>
    </div>
    <div class="form-group">
      <?= !empty($err)? $err : "" ?>
    </div>
    <div class="btn-group">
      <button class="btn success" name="sendInsert">insertar</button>
    </div>
  </form>
  <div class="flex-container">
    <?= create_cards($_SESSION["data"], $edit) ?>
  </div>
</section>