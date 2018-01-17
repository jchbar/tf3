<?php
session_start();
include_once('ClassBasedeDatos.php');
// echo '<script >extraigorif("form1")</script >';
echo 'rif session_cache_expire '.$_SESSION['rif'];
	$rifbuscar=$_SESSION['rif'];
	$con = new ClassBasedeDatos();
	$con->conectar();
	$valores='';

		$con->tabla = 'timbresfiscales';
		$con->id	= 'idregistro';
		$con->campos = array(
			array('campo'=>'idregistro','tipo'=>'NoMostrar','titulo'=>'idregistro','required'=>'required'),
			array('campo'=>'fechatimbre','tipo'=>'text','titulo'=>'Generado el','required'=>'required'),
			array('campo'=>'montobs','tipo'=>'text','titulo'=>'Monto Bs','required'=>'required'),
		array('campo'=>'montout','tipo'=>'text','titulo'=>'Cantidad UT','required'=>'required')
			);

	$query="select ";
	foreach ($con->campos as $campos)
	{
		$valores.=$campos[campo].',';
	}
	$valores=rtrim($valores,',');
	$query.=$valores. ' from '.$con->tabla;
	$query.=' WHERE riftimbre = "'.$rifbuscar.'" ';
	echo '<table class="table table-bordered">'; // striped">';
		
	foreach ($con->campos as $title)
	{
		if ($title['tipo'] == 'NoMostrar') $esconder=" style='display:none'";
		else $esconder='';
		echo '<th '.$esconder.'>'.$title['titulo'].'</th>';
	}

	///paginacion
	include 'pagination.php'; //incluir el archivo de paginación
	//las variables de paginación
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	$per_page = 3; //la cantidad de registros que desea mostrar
	$adjacents  = 4; //brecha entre páginas después de varios adyacentes
	$offset = ($page - 1) * $per_page;
echo $query;
	$result = $con->execute_query($query);
//		echo 'query='.$query;

	//Cuenta el número total de filas de la tabla
	$numrows = $con->num_rows($result);
	// echo 'filas'.$numrows;
	// if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
	$total_pages = ceil($numrows/$per_page);
	if ($numrows>0)
	{
		///
		$query.=' LIMIT '.$offset.','.$per_page;
		// $reload = 'index.php';
		$result = $con->execute_query($query);
		while ($fila = $con->fetch_assoc($result))
		{
			echo '<tr>';
			foreach ($con->campos as $tipo)
			{
				switch ($tipo['tipo'])
				{
					case 'text':
						echo '<td>'.$fila[$tipo["campo"]].'</td>';
					break;
				}
			}
			echo '<td><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button></td>
';
			
			echo '<td><a href='.$_SERVER['PHP_SELF'].'?'.$con->id.'='.$fila[$con->id].'&method=modificar class="btn btn-warning data-toggle=\"modal\" data-target=\"#myModal\"">Reportar Pago</a></td>';
			echo '<td><a href='.$_SERVER['PHP_SELF'].'?'.$con->id.'='.$fila[$con->id].'&method=eliminar class="btn btn-danger">Eliminar</a></td>';
			echo '</tr>';
		}
		echo '<tr colspan=""><tfoot>';
//		echo '<td><a href='.$_SERVER['PHP_SELF'].'?&method=agregar class="btn btn-primary">Agregar</a></td></tfoot>';
		echo '</table>';
		?>
		
		<div class="table-pagination pull-right">
			<?php 
			//echo paginate($reload, $page, $total_pages, $adjacents);
			echo paginate($_SERVER['PHP_SELF'], $page, $total_pages, $adjacents);
			?>
			
		</div>
		<?php
//	} else {
//			?>
<!--
			<div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>Aviso!!!</h4> No hay datos para mostrar
            </div>
-->
			<?php

		// }
		// $con->desconectar();
		// echo '<div id="termine">..............ooooooooooooooo</div>';
	}
	
	
	echo '<form action="opciones.php" method="POST">';
	echo '<div class="col-md-6">';
	echo '<button class="btn btn-danger" value="Regresar" name="Regresar">Regresar al Men&uacute;</button>'; 
	echo '</div>';
	echo '</form>';

	
?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>