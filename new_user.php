<?php
session_start();
if(!isset($_SESSION['usr'])) {
    header('Location:/');
}
include "includes/header.php";

if ($_POST['crear'] == "Registrar") {
  $get_error = "";

  if(empty($_POST['nombre'])){
    $get_error .= "El nombre es obligatorio <br>";
  }
  if(empty($_POST['apellido'])){
    $get_error .= "El apellido es obligatorio <br>";
  }
  if(empty($_POST['email'])){
    $get_error .= "El email es obligatorio <br>";
  }
  if(empty($_POST['telefono'])){
    $get_error .= "El apellido es obligatorio <br>";
  }
  if(empty($_POST['diplomado'])){
    $get_error .= "El diplomado es obligatorio <br>";
  }

  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $email = $_POST['email'];
  $telefono = $_POST['telefono'];
  $diplomado = $_POST['diplomado'];

  if(empty($get_error)){
    include_once "conexion.php";
    $verificacion = "SELECT * FROM courses WHERE email = '$email'";
    $result = $conn->query($verificacion);
    if ($result->num_rows > 0) {
      $get_duplicate = "Ya existe un usuario con ese email, intentalo nuevamente.";
	  } else {
      //insertar datos
      $sql = "INSERT INTO courses (nombre, apellido, email, telefono, diplomado) VALUES ('$nombre', '$apellido', '$email', '$telefono', '$diplomado')";
      if ($conn->query($sql) === TRUE) {
        $get_success = "Exito al cargar usuario";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    $conn->close();   
  }
}
?>

<div class="row">
  <div class="col-sm-6 offset-sm-3">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Registar usuario</h3>
      </div>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" name="apellido" value="<?php echo $apellido; ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="<?php echo $telefono; ?>">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="diplomado">Diplomado/Curso</label>
                <input type="text" class="form-control" name="diplomado" value="<?php echo $diplomado; ?>">
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-4 offset-8">
              <input type="submit" class="btn btn-primary btn-block" value="Registrar" name="crear">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
  include "includes/footer.php";
  if(!empty($get_error)){
    echo '<script>
            toastr["error"]("'.$get_error.'", "Error")
          </script>';
  }
  if(!empty($get_duplicate)){
    echo '<script>
            toastr["error"]("'.$get_duplicate.'", "Error")
          </script>';
  }
  if(!empty($get_success)){
    echo '<script>
            toastr["success"]("'.$get_success.'", "Exito");
            window.setTimeout(function(){
							window.location.href = "/dashboard.php";
						}, 1000);
          </script>';
  }
?>