<?php 
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'restaurante';

$link = new mysqli($servidor, $usuario, $senha, $banco);
$link->set_charset("utf8");

$mesa = $_GET['mesa'];
$nome = $_GET['nome'];
$numero = $_GET['numero'];
$prato = $_GET['prato'];
$data = $_GET['data'];
$hora = $_GET['hora'];
$termino = $_GET['termino'];

$sql = "INSERT INTO realizar_reserva(mesa_id,nome_pessoa,numero_pessoas,prato,data_reserva,hora_reserva,termino_reserva) VALUES ({$mesa},'{$nome}',{$numero},'{$prato}','{$data}','{$hora}','{$termino}')";

$query = $link->query($sql);

print $query;

$link->close();
?>