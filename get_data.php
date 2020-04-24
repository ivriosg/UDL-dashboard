<?php 
include_once "conexion.php";
$sql = "SELECT * FROM courses ORDER BY id";
$result = $conn->query($sql);
$datos = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }
    $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($datos),
    "iTotalDisplayRecords" => count($datos),
    "aaData"=>$datos);
    echo json_encode($results);
}
?>