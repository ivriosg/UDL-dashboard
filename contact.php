<?php
session_start();
if(!isset($_SESSION['usr'])) {
  header('Location:/');
}
include "includes/header.php";

$id = $_POST['id'];
$contacto = $_POST['contacto'];
include_once "conexion.php";

$sql = "SELECT * FROM courses WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $nombre = $row['nombre'];
    $apellido = $row['apellido'];
    $email = $row['email'];
    $telefono = $row['telefono'];
    $diplomado = $row['diplomado'];
  }
?>

<div class="row">
  <div class="col-sm-6 offset-sm-3">
    <?php
    //iniciar switch o case
    switch ($contacto) {
        case "email":
    ?>
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline card-success">
              <div class="card-header">
                <h3 class="card-title">
                  Email para <?php echo $nombre . " " . $apellido; ?>
                </h3>
              </div>
              <!-- /.card-header -->
              <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="card-body pad">
                  <div class="mb-3">
                    <div class="col">
                      <div class="form-group">
                        <input type="text" class="form-control" name="txt_subject" placeholder="Asunto">
                      </div>
                    </div>
                    <textarea class="textarea" placeholder="Escribe tu mensaje" name="txt_email" id="summernote" required 
                    style="width: 100%; height: 450px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
Hola <?php echo $nombre . " " . $apellido; ?>.<br>
Soy Dellanira Juarez de Educación Continúa de la Universidad de Londres.<br>
Te escribo porque solicitaste información sobre el curso de <?php echo $diplomado; ?>
                    </textarea>
                  </div>
                </div>
                <input type="hidden" value="<?php echo $nombre; ?>" name="nombre">
                <input type="hidden" value="<?php echo $apellido; ?>" name="apellido">
                <input type="hidden" value="<?php echo $email; ?>" name="email">
                <div class="card-footer">
                  <input type="submit" class="btn btn-success" value="Enviar Email">
                </div>
              </form>
            </div>
          </div>
          <!-- /.col-->
        </div>
        <!-- ./row -->
      </section>
          
    <?php
        break;
    case "whatsapp":
    ?>
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline card-success">
              <div class="card-header">
                <h3 class="card-title">
                  WhatsApp para <?php echo $nombre . " " . $apellido; ?>
                </h3>
              </div>
              <!-- /.card-header -->
              <form role="form" method="post" onsubmit="return false">
                <div class="card-body pad">
                  <div class="mb-3">
                    <input type="hidden" value="<?php echo substr($telefono, -10); ?>" id="tel_w">
                    <textarea class="textarea" placeholder="Escribe tu mensaje" id="texto" style="width: 100%; height: 250px;">
Hola <?php echo $nombre . " " . $apellido; ?>.
Soy Dellanira Juarez de Educación Continúa de la Universidad de Londres.
Te escribo porque solicitaste información sobre el curso de <?php echo $diplomado; ?>
                    </textarea>
                  </div>
                </div>
                <div class="card-footer">
                  <input type="submit" class="btn btn-success" value="Enviar WhatsApp" id="enviar_whats" onclick="whats();">
                </div>
              </form>
            </div>
          </div>
          <!-- /.col-->
        </div>
        <!-- ./row -->
      </section>

    <script>
        function whats(){
          let tlw = document.getElementById('tel_w').value;
          let msg = document.getElementById('texto').value;
          window.open(
            `https://api.whatsapp.com/send?phone=+52${tlw}&text=${msg}`,
            '_blank'
          );
          window.location = '/dashboard.php';
        }
    </script>

    <?php
        break;

    default:
        echo "No seleccionaste ninguno!";
        break;
}
} else {
    //echo "Datos Erroneos";
}
?>
        </div>
    </div>
<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $email = $_POST['email'];
  $txt_subject = $_POST['txt_subject'];
  $txt_email = $_POST['txt_email'];

  $cabeceras = "Content-type: text/html; charset=utf-8 \r\n";
  $cabeceras .= "From: dellanira.juarez@udlondres.com\n";
  $asunto = "$txt_subject"; 
  $email_to = "$email";
  $contenido = "$txt_email";
  if (@mail($email_to, $asunto ,$contenido ,$cabeceras )) {
    //actualizar la BD con el status de interesado.
    echo '
      <script>
          toastr["success"]("El email se envió con éxito", "Enviado");
          window.setTimeout(function(){
              window.location.href = "/dashboard.php";
          }, 2000);
      </script>
    ';
  } else {
    echo '
      <script>
        toastr["danger"]("Hubo un error al enviar el correo.", "Error");
      </script>
    ';
  }
}

include "includes/footer.php"; 
?>