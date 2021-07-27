<?php
include_once("inc/funciones.php");

function insertUser($name, $email, $pass, $roll){
  $sql = "INSERT INTO users (use_name, use_email, use_pass, use_roll) VALUES('{$name}', '{$email}', '{$pass}', '{$roll}')";
  sendData($sql);
}

function getAllUsers() {
  $sql = "SELECT use_name, use_email, COUNT(idfavorite) as use_nroFavorite FROM users JOIN favorites ON users.iduser = favorites.fav_iduser";
  $res = getData($sql);
  return !empty($res)? $res : [];
}

function getSession($email) {
  $sql = "SELECT iduser, use_pass, use_name, use_roll FROM users WHERE use_email='{$email}'";
  $res = getData($sql);
  return !empty($res)? $res : [];
}

function getFavorites($iduser){
  $sql = "SELECT idfavorite, fav_title, fav_url, fav_description, fav_isfavorite FROM favorites WHERE fav_iduser= {$iduser}";
  $res = getData($sql);
  return !empty($res)? $res : [];
}

function updateFavorites($id, $url, $description, $checked){
  $sql = "UPDATE favorites SET fav_url = '{$url}', fav_description = '{$description}', fav_isfavorite = '{$checked}' WHERE idfavorite = {$id}";
  sendData($sql);
}

function insertFavorites($iduser, $title, $url, $description, $checked){
  $sql = "INSERT INTO favorites (fav_iduser, fav_title, fav_url, fav_description, fav_isfavorite) VALUES({$iduser}, '{$title}', '{$url}', '{$description}', '{$checked}')";
  sendData($sql);
}

function deleteFavorites($id){
  $sql = "DELETE FROM favorites WHERE idfavorite = {$id}";
  sendData($sql);
}
