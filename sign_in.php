<?php
if ($_POST['registro'] == "Registarse") {
  $get_error = $error_login = "";

  if(empty($_POST['nombre'])){
    $get_error .= "El nombre es obligatorio <br>";
  }
  if(empty($_POST['usuario'])){
    $get_error .= "El usuario es obligatorio <br>";
  }
  if(empty($_POST['email'])){
    $get_error .= "El email es obligatorio <br>";
  }
  if(empty($_POST['password'])){
    $get_error .= "El password es obligatorio <br>";
  }

  $usuario = $_POST['usuario'];
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $og_password = $pass;

  //password encriptado 
  $pass = hash("sha512", $pass);	
  $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

  if(empty($get_error)){
    include_once "conexion.php";
    $sql = "INSERT INTO users (nombre, usuario, email, password) VALUES ('$nombre', '$usuario', '$email', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
      $success = "El usuario se registro exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Registro - EDUCON UDL</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="includes/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="includes/dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="/"><b>EDUCON</b> UDL</a>
  </div>
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nombre" name="nombre">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario" name="usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4 offset-8">
            <input type="submit" class="btn btn-primary btn-block" value="Registarse" name="registro">
          </div>
        </div>
      </form>
      <a href="/" class="text-center">Login</a>
    </div>
</div>

<script src="includes/plugins/jquery/jquery.min.js"></script>
<script src="includes/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</body>
</html>

<?php
  if(!empty($get_error)){
    echo '<script>
            toastr["error"]("'.$get_error.'", "Error")
          </script>';
  }
  if(!empty($success)){
    echo '<script>
            toastr["success"]("'.$success.'", "Exito")
            window.setTimeout(function(){
              window.location.href = "/dashboard.php";
            }, 500);
          </script>';
  }
?>