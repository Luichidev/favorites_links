<?php 

  session_start();  
  require_once("inc/funciones.php");
  
  $validado = false;
  $baneado = false;
  $edit = false;
  $email = "";
  $name = "";
  $pass = "";
  $err = "";
  
  if(!isset($_SESSION["count"]))
    $_SESSION["count"] = 3;

  if(!isset($_SESSION["auth"]))
    $_SESSION["auth"] = false;

  if(!isset($_SESSION["cards"]))
    $_SESSION["cards"] = [];

  if($_SERVER["REQUEST_METHOD"] === "POST"){

    if(isset($_POST['login'])){
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        $err .="<p class=\"noAuth\">*Introduzca un correo valido! 🚫</p>";
      
      $email = sanitize($_POST["email"]);
      $pass = sanitize($_POST["password"]);
      
      if(empty($pass)) 
        $err .="<p class=\"noAuth\">*La contraseña no puede estar vacía 🚫</p>";
      
      if(empty($err)){
        $validado = true;
        $data = getSession($email);
        if(is_array($data) && !empty($data)){
          foreach ($data as $value) {
            if(password_verify($pass, $value["use_pass"])){
              $_SESSION["auth"] = true;
              $_SESSION["name"] = ucfirst($value["use_name"]);
              $_SESSION["idusers"] = $value["idusers"];
              $contents = ["IP" => $_SERVER["REMOTE_ADDR"], "Navegador" => $_SERVER["HTTP_USER_AGENT"], "Email" => $email, "Nombre" => $_SESSION["name"]];
              $message = "user logged in successfully";
              build_logs($contents,$message);
              $_SESSION["cards"] = getFavorites($_SESSION["idusers"]);
            } 
          }
        }

        if($_SESSION["auth"])
          $_SESSION["count"] = 3;
        else 
          $_SESSION["count"]--;
      }
    }

    if(isset($_POST["edit"])){
      $edit = true;
    }

    if(isset($_POST["sendEdit"])){
      $id = $_POST["idfav"];
      $url = sanitize($_POST["url"]);
      $description = sanitize($_POST["description"]);
      if(empty($url))
        $err .= "<p class=\"noAuth\">*La URL no puede estar vacía 🚫</p>";
      if(empty($err)){
        updateFavorites($id, $url, $description);
        $_SESSION["cards"] = getFavorites($_SESSION["idusers"]);
      }
    }

    if(isset($_POST["sendInsert"])){
      $title = sanitize($_POST["title"]);
      $url = sanitize($_POST["url"]);
      $description = sanitize($_POST["description"]);
      if(empty($title))
        $err .= "<p class=\"noAuth\">*El titulo no puede estar vacío 🚫</p>";
      if(empty($url))
        $err .= "<p class=\"noAuth\">*La URL no puede estar vacía 🚫</p>";

      if(empty($err)){
        insertFavorites($_SESSION["idusers"], $title, $url, $description);
        $_SESSION["cards"] = getFavorites($_SESSION["idusers"]);
      }

    }

    if(isset($_POST["sendDel"])){
      $id = $_POST["idfav"];
      deleteFavorites($id);
      $_SESSION["cards"] = getFavorites($_SESSION["idusers"]);
    }

    if(isset($_POST["sendRegister"])){
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        $err .="<p class=\"noAuth\">*Introduzca un correo valido! 🚫</p>";
      
      $email = sanitize($_POST["email"]);
      $name = sanitize($_POST["name"]);
      $pass = sanitize($_POST["password"]);
      
      if(empty($name)) 
        $err .="<p class=\"noAuth\">*El campo nombre es obligatorio 🚫</p>";

      if(empty($pass)) 
        $err .="<p class=\"noAuth\">*La contraseña no puede estar vacía 🚫</p>";
      
      if(empty($err)){
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        insertUser($name, $email, $pass);
        header("location:index.php");
      }
    }



    //si no esta baneado, no es un logout y no esta autentificado se crea el session_log
    if($_SESSION["count"] > 0 && !isset($_POST["logout"]) && !$_SESSION["auth"]){
      $contents = ["IP" => $_SERVER["REMOTE_ADDR"], "Navegador" => $_SERVER["HTTP_USER_AGENT"], "Email" => $email];
      $message = "Try to connect";
      build_logs($contents,$message);
    }

  }

  if($_SERVER["REQUEST_METHOD"] === "GET"){
    if(isset($_GET["logout"])){
      session_destroy();
      $_SESSION["auth"] = false;
      $_SESSION["cards"] = [];
    }
  }

  if($_SESSION["count"] <= 0){
    $contents = ["IP" => $_SERVER["REMOTE_ADDR"], "Navegador" => $_SERVER["HTTP_USER_AGENT"]];
    $message = "ip banned";
    build_logs($contents,$message);
    $baneado = true;

  }