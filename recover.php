<?php

$email = $_GET['email'];
$usuario = $_GET['usuario'];

if ($_POST['recover'] == "Cambiar password") {
  $get_error = $error_login = "";

  if(empty($_POST['pass'])){
    $get_error .= "El password es obligatorio.<br>";
  }
  if(empty($_POST['v_pass'])){
    $get_error .= "La confirmación del password es obligatorio.<br>";
  }

  $pass = $_POST['pass'];
  $v_pass = $_POST['v_pass'];

  if(empty($get_error)){
    include_once "conexion.php";
    $sql = "SELECT * FROM users WHERE email = '$email' AND usuario = '$usuario'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $email = $row['email'];
        $nombre = $row['nombre'];
        $usuario = $row['usuario'];
      }  
      $cabeceras = "Content-type: text/html; charset=utf-8 \r\n";
      $cabeceras .= "From: Ivan Rios <ivan.rios@udlondres.com>\n";
      $asunto = "Recuperar contraseña"; 
      $email_to = "$email";
      $contenido = "
          Hola $nombre, para recuperar tu password, debes de dar clic en el siguiente link:<br>
          <a href='https://dellanira.marketingconweb.com/recover.php?email=$email&usuario=$usuario' target='_blank'>Recuperar</a>
      ";
      if (@mail($email_to, $asunto ,$contenido ,$cabeceras )) {
        $success = "Se envió un correo electrónico con las instrucciones para recuperar el password.";
      }
    } else {
      $get_error .= "El email no esta registrado.";
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
  <title>Recuperar contraseña - EDUCON UDL</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="includes/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="includes/dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  <a href="/"><b>EDUCON</b> UDL</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Escribe tu nuevo password para tener acceso a la plataforma.</p>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="pass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirmar Password" name="v_pass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input type="submit" class="btn btn-primary btn-block" value="Cambiar password" name="recover">
          </div>
          <!-- /.col -->
        </div>
      </form>


    </div>
  </div>
</div>

<script src="includes/plugins/jquery/jquery.min.js"></script>
<script src="includes/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="includes/dist/js/adminlte.min.js"></script>
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
              window.location.href = "/";
            }, 2000);
          </script>';
  }
?>