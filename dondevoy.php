<?php
session_start();
	if ($_POST['consulTar'])
	{
		echo '<form id="algo" method="POST">';
			echo '<input type="hidden" id="consulTar" value="consulTar">';
			include_once('tributos.php');
		echo '</form>';
	}
/*
	else if ($_POST['adquiRir'])
	{
		echo '<form id="algo" method="POST">';
		echo '<input type="hidden" id="adquiRir" value="adquiRir">';
		include_once('tributos.php');
		echo '</form>';
	}
*/
	else if ($_POST['RegisTrarse'])
	{
		include_once('registro.php');		
	}
	else if ($_POST['IngreSar'])
	{
//		die($_POST['IngreSar']);
		include('ingresar.php');		
	}
?>
