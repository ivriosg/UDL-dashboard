<?php
session_start();
if(!isset($_SESSION['usr'])) {
  header('Location:/');
}
  include "includes/header.php";
  include_once "conexion.php";

  if(isset($_POST['import_data'])){
    $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)) {
      if(is_uploaded_file($_FILES['file']['tmp_name'])) {
        $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
        while(($data = fgetcsv($csv_file)) !== FALSE) {
          $check_data = "SELECT nombre, apellido, email, telefono, diplomado FROM courses WHERE email = '".$data[2]."'";
          $result = $conn->query($check_data);
          if ($result->num_rows > 0) {
            echo '<script>
                    window.setTimeout(function(){
                      window.location.href = "/dashboard.php";
                    }, 1000);
                  </script>'; 
          } else {
            $sql = "INSERT INTO courses (nombre, apellido, email, telefono, diplomado) VALUES ('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]')";
            if ($conn->query($sql) === TRUE) {
              $success = "";
              echo '<script>
                    window.setTimeout(function(){
                      window.location.href = "/dashboard.php";
                    }, 1000);
                  </script>';
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
          }
        }
        fclose($csv_file);
      } else {
        $import_status = '?import_status=error';
      }
    } else {
      $import_status = '?import_status=invalid_file';
    }
  }

?>
  <div class="row">
    <div class="col-sm-4 offset-sm-4">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Subir CSV</h3>
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" id="import_form">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="file">
                    <label class="custom-file-label" for="customFile">Seleccionar archivo</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer float-right">
            <input type="submit" class="btn btn-primary" value="Cargar" name="import_data">
          </div>
        </form>
      </div>
    </div>
  </div>

<?php
  include "includes/footer.php";
?>