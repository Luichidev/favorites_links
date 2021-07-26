<?php
/* FUNCIONES 
  Author: @Luichidev
  Web: https://luisalbertoarana.com
  Creation_Date: 26/07/2021
  Revision: 26/07/2021
*/

//PROTOTIPO: String sanitize(String $value)
//DESCRIPCIÓN:  Devuelve un String saneado, es decir, quita elementos 
//              html del String y los espacios en blanco 
//              enviado por parámetros.
function sanitize($value){
  return strip_tags(trim($value));
}

//PROTOTIPO: String today()
//DESCRIPCIÓN:  Devuelve un String con la fecha y hora actual, si le enviás
//              por parámetros la letra "d" te dará solo la fecha actual.
function today($mode=""){
  $res = "";
  if(!$mode)
    $res = date("j/n/Y \- G:i:s");
    // $res = date("j/n/Y \a \l\a\s G:i:s");
  elseif($mode === "d") 
    $res = date("j/n/Y");

  return $res;
}
//PROTOTIPO: Void build_logs(Array $contents)
//DESCRIPCIÓN:  Recibe un array con el contenido del logs
//              y lo crea.
function build_logs($contents, $msg){
  if($link_logs = fopen("logs/session_logs.txt", "a")){
    $line = "[" . today() . "]=>";
    fwrite($link_logs, $line);
    foreach ($contents as $key => $value) {
      $line = "{$key}: {$value} ";
      fwrite($link_logs, $line);
    }
    $line = " {$msg}." . PHP_EOL;
    fwrite($link_logs, $line);
    fclose($link_logs); 
  }
}
//PROTOTIPO: String dump_var(Array $array)
//DESCRIPCIÓN : Devuelve el contenido de un array 
//              formateado para el cliente (navegador)
function dump_var($array) {
  echo "<pre>";
  print_r($array);
  echo "</pre>";
}
//PROTOTIPO: Array getData(String $sql)
//DESCRIPCIÓN : Devuelve los datos solicitados por la sql
function getData($sql) {
  $dblink = conectar();
  $data = [];
  
  if($dblink){
    $resultado = mysqli_query($dblink, $sql);
    if(mysqli_num_rows($resultado)){
      while($fila = mysqli_fetch_assoc($resultado)){
        $data[] = $fila;
      }
      mysqli_free_result($resultado);
    }
    cerrar_conexion($dblink);
  } 
  return $data;
}
//PROTOTIPO: void sendData(String $sql)
//DESCRIPCIÓN : Inserta, actualiza o borra un registro 
//              de la base de datos, si todo fue bien
//              devuelve true
function sendData($sql) {
  $dblink = conectar();
  if($dblink){
    $resultado = mysqli_query($dblink, $sql);
    cerrar_conexion($dblink);
  }  
}

//PROTOTIPO: Source conectar()
//DESCRIPCIÓN : Se conecta a la base de datos, si todo fue bien , devuelve el enlace de la conexión
function conectar() {
  $dbHost = "localhost";
  $dbUser = "luichidev";
  $dbPass = "admin123";
  $dbName = "favorites_db";
  
  $res = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

  if(!mysqli_connect_errno()){
    mysqli_set_charset($res, 'utf8mb4');
    return $res;
  } else {
    echo 'Error de conexión: ', mysqli_connect_error();
    return null;
  }
  
}
//PROTOTIPO: Void cerrar_conexion(Resource $dblink)
//DESCRIPCIÓN : Recibe un enlace a una base de datos y la cierra
function cerrar_conexion($dblink){
  mysqli_close($dblink);
}
//PROTOTIPO: String create_cards(Array $array, boolean $edit)
//DESCRIPCIÓN : Recibe un array con las card a crear edit si 
//              hay que renderizar el botón edit.
function create_cards($array, $edit){
  $res = "";
  if(!empty($array)){
    foreach ($array as $value) {
      if($edit){
        $button = "<button class=\"btn success\" name=\"sendEdit\">Editar ✈️</button>" . PHP_EOL;
        $button_del = "";
        $url = "<label><span>URL:</span></label><input type=\"text\" name=\"url\" value=\"{$value["fav_url"]}\">" . PHP_EOL;
        $des = "<textarea name=\"description\">{$value["fav_description"]}</textarea>" . PHP_EOL;
      }else {
        $button = "<button class=\"btn success\" name=\"edit\">Edit ✏️</button>" . PHP_EOL;
        $button_del = "<button class=\"btn danger\" name=\"sendDel\">Borrar 🗑️</button>" . PHP_EOL;
        $url = "<label><span>URL:</span></label><input disabled type=\"text\" value=\"{$value["fav_url"]}\">". PHP_EOL;
        $des = "<textarea disabled>{$value["fav_description"]}</textarea>" . PHP_EOL;
      }

      $res .= "<form class=\"card\" action='" . $_SERVER["PHP_SELF"] . "' method=\"POST\">" . PHP_EOL;
      $res .= "<input type=\"text\" name=\"idfav\" value=\"{$value["idfavorite"]}\" hidden>";
      $res .= "<div class=\"card-title\">".PHP_EOL."<h2>{$value["fav_title"]}</h2>".PHP_EOL."</div>".PHP_EOL."<div class=\"card-body\">" . PHP_EOL;
      $res .= $url;
      $res .= "<label><span>ir - a </span></label><a href=\"{$value["fav_url"]}\" target=\"_blank\" rel=\"noopener noreferrer\" rel>{$value["fav_title"]}</a><br>";
      $res .= "<label><span>Descripción:</span></label>";
      $res .= $des;
      $res .= $value["fav_isfavorite"] == "1"
              ? "<label><span>Público:</span></label><input type=\"checkbox\" name=\"esPublico\" checked>" . PHP_EOL 
              : "<label><span>Público:</span></label><input type=\"checkbox\" name=\"esPublico\" >" . PHP_EOL ;
      $res .= "</div>".PHP_EOL."<div class=\"card-footer\">";
      $res .= $button;
      $res .= $button_del;
      $res .= "</div></form>";
    }
  }
  return $res;
}