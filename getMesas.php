<?php 
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'restaurante';

$link = new mysqli($servidor, $usuario, $senha, $banco);
$link->set_charset("utf8");

$sql = "SELECT * FROM mesas_restaurante";
$query = $link->query($sql);

$rows = array();
while ($row = $query->fetch_assoc()) {
	$rows[] = $row;
}

print json_encode($rows,JSON_NUMERIC_CHECK);
$link->close();
?>