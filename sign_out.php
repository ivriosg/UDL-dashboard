<?php
session_start();
if(!isset($_SESSION['usr'])) {
  header('Location:/');
}
include "includes/header.php";

session_unset();
session_destroy();

echo '
  <div class="col-6 offset-3">
    <div class="alert alert-danger alert-dismissible m-5 text-center">
    <h5><i class="icon fas fa-ban"></i> Espera!</h5>
      ¡Estamos cerrando tu sesion!
    </div>
  </div>
  <script>
    window.setTimeout(function(){
      window.location.href = "/dashboard.php";
    }, 2000);
  </script>
';

include "includes/footer.php";
?>