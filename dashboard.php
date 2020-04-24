<?php
session_start();
if(!isset($_SESSION['usr'])) {
  header('Location:/');
}
  include "includes/header.php";
  include_once "conexion.php";

  if ($_POST['send_int'] == "Guardar") {
    $get_error = "";
  
    if(empty($_POST['interesado'])){
      $get_error .= "Debes seleccionar un estatus. <br>";
    }
    $interesado = $_POST['interesado'];
    $id = $_POST['id'];
  
    if(empty($get_error)){
      $sql = "UPDATE courses SET interesado = '$interesado' WHERE id = $id ";
      if ($conn->query($sql) === TRUE) {
        //echo "Record updated successfully"; 
        echo '<script>
                toastr["success"]("El estatus del lead se actualizo correctamente.", "Exito");
              </script>';
      } else {
        echo "Error updating record: " . $conn->error;
      }
    }
  }
?>
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Contactos</h3>
        <div class="card-tools">
          <div class="input-group input-group-sm">
            <a href="new_user.php" class="btn bg-gradient-primary" style="margin-right: 10px;">
              Agregar
            </a>
            <a href="csv.php" class="btn bg-gradient-primary">
              Subir CSV
            </a>
          </div>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-head-fixed text-nowrap">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Email</th>
              <th>Teléfono</th>
              <th>Diplomado / Curso</th>
              <th>Contactado</th>
              <th>Interesado</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            if (isset($_GET['page'])) {
              $page = $_GET['page'];
            } else {
              $page = 1;
            }
            $no_of_records_per_page = 10;
            $offset = ($page-1) * $no_of_records_per_page;
            $total_pages_sql = "SELECT COUNT(*) FROM courses";
            $result = $conn->query($total_pages_sql);
            $total_rows = mysqli_fetch_array($result)[0];
            $total_pages = ceil($total_rows / $no_of_records_per_page);
            

            $sql = "SELECT * FROM courses ORDER BY id LIMIT $offset, $no_of_records_per_page";
            $result = $conn->query($sql);
            $datos = array();
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                $datos[] = $row;
              }
              foreach($datos as $dato) { ?>
                <tr>
                  <td>
                    <?php echo $dato["nombre"] . " " . $dato["apellido"]; ?>
                  </td>
                  <td><?php echo $dato["email"]; ?></td>
                  <td><?php echo $dato["telefono"]; ?></td>
                  <td><?php echo $dato["diplomado"]; ?></td>
                  <td>
                    <?php 
                      if(is_null($dato["contactado"])) {
                      ?>  
                        <form method="post" action="contact.php">  
                          <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="contacto" value="email">
                            <label class="form-check-label" for="email">
                              Email
                            </label>
                          </div>
                          <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="contacto" value="whatsapp">
                            <label class="form-check-label" for="whatsapp">
                              WhatsApp
                            </label>
                          </div>
                          <input type="hidden" name="id" value="<?php echo $dato["id"] ?>">
                          <input type="submit" value="Enviar" class="btn btn-block btn-info btn-flat">
                        </form>
                      <?php
                      } else {
                        echo "Si";
                      }
                    ?>
                  </td>
                  <td>
                    <?php
                    if(is_null($dato["interesado"])) {
                      ?>
                      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
                        <div class="form-check-inline">
                          <input class="form-check-input" type="radio" name="interesado" value="Si">
                          <label class="form-check-label" for="si">
                            Si
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <input class="form-check-input" type="radio" name="interesado" value="No">
                          <label class="form-check-label" for="no">
                            No
                          </label>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $dato["id"] ?>">
                        <input type="submit" class="btn btn-block btn-success btn-flat" value="Guardar" name="send_int">
                      </form>
                    <?php
                    } else {
                      echo $dato["interesado"];
                    }
                    ?>
                  </td>
                  <td>
                    <a href="update.php?id=<?php echo $dato["id"]; ?>">
                      <i class="far fa-edit"></i>
                    </a>
                    <a href="delete.php?id=<?php echo $dato["id"]; ?>">
                      <i class="far fa-times-circle"></i> 
                    </a>
                  </td>
                </tr>
              <?php 
              }
            } else {
              $error_data = "No existe ningún registro.";
            }
            ?>
          </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item">
                <a href="?page=1" aria-label="Previous" class="page-link">
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
              
              <li class="<?php if($page <= 1){ echo 'disabled'; } ?> page-item active">
                <a href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page); } ?>" class="page-link">
                  <?php echo $page; ?>
                </a>
              </li>

              <li class="<?php if($page >= $total_pages){ echo 'disabled'; } ?> page-item">
                <a href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>" class="page-link">
                  <?php echo $page + 1; ?>
                </a>
              </li>

              <li class="page-item">
                <a href="?page=<?php echo $total_pages; ?>" class="page-link">
                  <span aria-hidden="true">&raquo;</span>
                  <span class="sr-only">Next</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <?php
          if(!empty($error_data)){
            echo '
              <div class="alert alert-danger alert-dismissible m-5 text-center">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                '.$error_data.'
              </div>
            ';
          }
        ?>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>