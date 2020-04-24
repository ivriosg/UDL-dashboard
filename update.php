<?php
session_start();
if(!isset($_SESSION['usr'])) {
  header('Location:/');
}
include "includes/header.php";
include_once "conexion.php";

if($_POST['actualiza'] == "Actualizar") {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $email = $_POST['email'];
  $telefono = $_POST['telefono'];
  $diplomado = $_POST['diplomado'];
  $id = $_POST['id_usuario'];
  $interesado = $_POST['interesado'];
  
  $sql = "UPDATE courses SET nombre = '$nombre', apellido = '$apellido', email = '$email', telefono = '$telefono', diplomado = '$diplomado' WHERE id = $id";
  if ($conn->query($sql) === TRUE) {
    echo '<script>
            toastr["success"]("El usuario se actualizo correctamente.", "Exito");
            window.setTimeout(function(){
              window.location.href = "/dashboard.php";
            }, 1000);
          </script>';
    header("Location: /dashboard.php");
  } else {
    echo "Error updating record: " . $conn->error;
  }
}

$id = $_GET['id'];
$sql = "SELECT * FROM courses WHERE id = $id";
$result = $conn->query($sql);
$datos = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $datos[] = $row;
  }
  foreach($datos as $dato) {
?>
    <div class="row">
      <div class="col-sm-8 offset-sm-2">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Actualizar datos</h3>
          </div>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" value="<?php echo $dato['nombre']; ?>" name="nombre">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" value="<?php echo $dato['apellido']; ?>" name="apellido">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="nombre">Email</label>
                    <input type="email" class="form-control" value="<?php echo $dato['email']; ?>" name="email">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="apellido">Teléfono</label>
                    <input type="text" class="form-control" value="<?php echo $dato['telefono']; ?>" name="telefono">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="apellido">Diplomado/Curso</label>
                    <input type="text" class="form-control" value="<?php echo $dato['diplomado']; ?>" name="diplomado">
                  </div>
                </div>
              </div>
              <input type="hidden" value="<?php echo $id;?>" name="id_usuario">
            </div>
            <div class="card-footer">
              <input type="submit" class="btn btn-primary" value="Actualizar" name="actualiza">
            </div>
          </form>
        </div>
      </div>
    </div>
<?php
  }
} else {
  $err_load_upd = "No se pueden cargar los datos, intentalo nuevamente.";
}

$conn->close();
include "includes/footer.php";

if(!empty($err_upd)){
  echo '
    <div class="alert alert-danger alert-dismissible m-5 text-center">
      <h5><i class="icon fas fa-ban"></i> Error!</h5>
      '.$err_load_upd.'
    </div>
  ';
}
?>