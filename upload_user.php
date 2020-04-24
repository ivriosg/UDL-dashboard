<?php
  include_once "conexion.php";
  $email = "";
  $pass = sha1('');

  $array = $array;
  $sql = "INSERT INTO users (nombre, usuario, email, password) VALUES ('Ivan Rios', 'ivriosg', '" . $email . "', '$pass')";

  $database = new Connection();
  $db = $database->open();
  try {
      // hacer uso de una declaración preparada para evitar la inyección de sql
      $resultado = $db->prepare($sql);
      $resultado->execute($array);
      echo json_encode("Persona Guardada");
  } catch(PDOException $e){
      $_SESSION['message'] = $e->getMessage();
  }

  //cerrar conexión
  $database->close();
?>