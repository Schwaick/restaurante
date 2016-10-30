<?php 
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'restaurante';

$link = new mysqli($servidor, $usuario, $senha, $banco);
$link->set_charset("utf8");

$data = $_GET['data'];
$hora = $_GET['hora'];

$sql = "SELECT * FROM realizar_reserva WHERE data_reserva = '{$data}' AND '{$hora}' >= hora_reserva AND '{$hora}' < termino_reserva";
$query = $link->query($sql);

$rows = array();
while ($row = $query->fetch_assoc()) {
	$rows[] = $row;
}

print json_encode($rows,JSON_NUMERIC_CHECK);
$link->close();
?>