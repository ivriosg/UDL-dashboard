<?php
if ($_POST['ingresar'] == "Entrar") {
  $get_error = $error_login = "";

  if(empty($_POST['usuario'])){
    $get_error .= "El usuario es obligatorio <br>";
  }
  if(empty($_POST['pass'])){
    $get_error .= "El password es obligatorio <br>";
  }

  $usuario = $_POST['usuario'];
  $pass = $_POST['pass'];
  $password_form = $pass;
  $password_form = hash("sha512", $password_form);
  

  if(empty($get_error)){
    include_once "conexion.php";
    $sql = "SELECT * FROM users WHERE usuario = '$usuario'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $password_db = $row["password"];
      }  
      $verify = password_verify($password_form, $password_db);

      if ($verify == "true") {
        session_start();
        $_SESSION['usr']=$usuario;
        header("Location: dashboard.php");
      }
    } else {
      $error_login .= "El usuario o password son incorrectos.";
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
  <title>Base de Datos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="includes/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="includes/dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>EDUCON</b> UDL</a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Iniciar Sesión</p>

      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario" name="usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="pass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4 offset-8">
            <input type="submit" class="btn btn-primary btn-block" value="Entrar" name="ingresar">
          </div>
        </div>
      </form>

      <p class="mb-1">
        <a href="forgot.php">Olvide mi contraseña</a>
      </p>
      <p class="mb-0">
        <a href="sign_in.php" class="text-center">Registrarse</a>
      </p>
    </div>
  </div>
</div>

<script src="includes/plugins/jquery/jquery.min.js"></script>
<script src="includes/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="includes/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
  if(!empty($get_error)){
    echo '<script>
            toastr["error"]("'.$get_error.'", "Error")
          </script>';
  }
  if(!empty($error_login)){
    echo '<script>
            toastr["error"]("'.$error_login.'", "Error")
          </script>';
  }
?>