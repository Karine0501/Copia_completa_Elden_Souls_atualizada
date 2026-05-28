<?php
if (isset($_COOKIE['administrador'])) {
	require_once 'model/Administrador.php';
	$administrador=new Administrador();
	$administrador->deslogar();
	header('location: index.php');
	exit();
}
if (isset($_COOKIE['cliente'])) {
	require_once 'model/Cliente.php';
	$cliente=new Cliente();
	$cliente->deslogar();
	header('location: index.php');
	exit();
}
?>