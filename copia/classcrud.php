<?php
include_once('classbasededatos.php');

class classcrud
{
	var $tabla;
	var $id;
	var $campos = array();
	var $header = '<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="../bootstrap/js/jquery3.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>';
	var $styletable='table table-bordered';
	
	function _construct ()
	{
		// nada 
	}
	
	function generarTabla()
	{
		$con = new classbasededatos();
		$con->conectar();
		$valores='';
		$query="select ";
		foreach ($this->campos as $campos)
		{
			$valores.=$campos[campo].',';
		}
		$valores=rtrim($valores,',');
		$query.=$valores. ' from '.$this->tabla;
		echo '<table class="table table-bordered">'; // striped">';


		
		foreach ($this->campos as $title)
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

		$result = $con->execute_query($query);
//		echo 'query='.$query;

		//Cuenta el número total de filas de la tabla*/
		$numrows = $con->num_rows($result);
		// echo 'filas'.$numrows;
		// if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
		$total_pages = ceil($numrows/$per_page);
		if ($numrows>0){
		///

		$query.=' LIMIT '.$offset.','.$per_page;
		// $reload = 'index.php';
		$result = $con->execute_query($query);
		while ($fila = $con->fetch_assoc($result))
		{
			echo '<tr>';
			foreach ($this->campos as $tipo)
			{
				switch ($tipo['tipo'])
				{
					case 'text':
						echo '<td>'.$fila[$tipo["campo"]].'</td>';
					break;
/*
					case 'NoMostrar':
						echo '<td> '.$fila[$tipo["campo"]].'</td>';
					break;
*/				
				}
			}
			echo '<td><a href='.$_SERVER['PHP_SELF'].'?'.$this->id.'='.$fila[$this->id].'&method=modificar class="btn btn-success">Modificar</a></td>';
			echo '<td><a href='.$_SERVER['PHP_SELF'].'?'.$this->id.'='.$fila[$this->id].'&method=eliminar class="btn btn-danger">Eliminar</a></td>';
			echo '</tr>';
		}
		echo '<tr colspan=""><tfoot>';
		echo '<td><a href='.$_SERVER['PHP_SELF'].'?&method=agregar class="btn btn-primary">Agregar</a></td></tfoot>';
		echo '</table>';
		?>
		<div class="table-pagination pull-right">
			<?php 
			//echo paginate($reload, $page, $total_pages, $adjacents);
			echo paginate($_SERVER['PHP_SELF'], $page, $total_pages, $adjacents);
			?>
			
		</div>
		
		<?php
/*

		} else {
			?>
			<div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>Aviso!!!</h4> No hay datos para mostrar
            </div>
			<?php
*/
		}
		
		
	}
	
	function MostrarBotonAliado()
	{
		$con = new classbasededatos();
		$con->conectar();
		$comando="select * from configuracion where nombreparametro='ActivarAliados'";
		$result = $con->consulta($comando);
		$res = $con->fetch_assoc($result);
		if ($fila['valorparametro'] == 'Si')
		{
			echo '<div class="col-xs-12 col-sm-2 col-md-2`">';
			echo '<button class="btn btn-warning" value="quieroser" name="quieRoser">Quieres ser Aliado?</button>';
			echo '</div>';
		}
	}
	
	function MostrarLogoRegion()
	{
		$con = new classbasededatos();
		$con->conectar();
		$comando="select * from configuracion where nombreparametro='logoregion'";
		$result = $con->consulta($comando);
		if ($con->num_rows($result) > 0)
		{
//		echo '1...'.$comando;
				$imagen=$con->fetch_assoc($result);
				$imagen=$imagen['valorparametro'];
				echo '<div align="center" class="hidden-xs col-xs-12 col-sm-8 col-md-9">'; // hidden-sm 
				echo '<img src='.$imagen.' class="img-resposive" alt="Logo de la Region" widht="100" height="100">';
				echo '<div>';
		}
		else echo '	<h1>Sin Logo Region</h1>';
	}
	
	function agregarRegistro()
	{
		echo 'agregar';
	}

	function eliminarRegistro()
	{
		echo 'agregar';
	}
	function modificarRegistro()
	{
		echo 'agregar';
	}
	
}
