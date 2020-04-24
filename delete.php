<?php
session_start();
if(!isset($_SESSION['usr'])) {
  header('Location:/');
}
include "includes/header.php";
include_once "conexion.php";

$id = $_GET['id'];
$sql = "DELETE FROM courses WHERE id = $id";
if ($conn->query($sql) === TRUE) {
  echo '
    <div class="col-6 offset-3">
      <div class="alert alert-danger alert-dismissible m-5 text-center">
      <h5><i class="icon fas fa-ban"></i> Espera!</h5>
        Se esta eliminando el usuario, espera por favor.
      </div>
    </div>
    <script>
      window.setTimeout(function(){
        window.location.href = "/dashboard.php";
      }, 2000);
    </script>
  ';
} else {
  echo '
    <script>
      toastr["danger"]("Hubo un error al borrar el usuario.", "Error");
      window.setTimeout(function(){
        window.location.href = "/dashboard.php";
      }, 2000);
    </script>
  ';
}

$conn->close();
include "includes/footer.php";
?>