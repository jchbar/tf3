<?php
include_once('classbasededatos.php');

class classtributos
{

	function __construct ()
	{
		// nada 
	}
	
	function pedir_rif()
	{
		// echo '<section class="row">';
		// echo '<div class="form-group">';
//			echo '<div class="col-xs-12 col-sm-2 col-md-1 col-lg-1" >';
				echo '<input type="hidden" id="adquiRir" name="adquiRir" value="adquiRir">';
				if ($_SESSION['rif'])
				{
					echo '<input class="form-control" type="hidden" name="nacionalidad" id="nacionalidad" value="'.$_POST['nacionalidad'].'">';
					echo '<label>RIF </label>';
					echo $_SESSION['rif'];
					echo '<label>Nombre/Raz&oacute;n Social</label>';
					$con = new ClassBasedeDatos();
					$con->conectar();
					$comando = "select * from usuarios where rif_usuario = '".$_SESSION['rif']."'";
					$resultado=$con->consulta($comando);
					$fila=$con->fetch_assoc($resultado);
					echo $fila['nombre_usuario'];
					echo '<input type="hidden" name="razon" id="razon" value="'.$fila['nombre_usuario'].'">';
					$con->desconectar();
				}
				else {
					echo '<label>Nacionalidad</label>';
					$comando="select * from configuracion where nombreparametro = 'nacionalidad' order by valorparametro" ;
					$res=mysql_query($comando);
					echo '<select class="form-control" name="nacionalidad" id="nacionalidad" size="1">';
					while ($fila = mysql_fetch_assoc($res)) {
						echo '<option '.($fila['valorparametro']=='V'?' selected="selected" ':'') .' value="'.$fila['valorparametro'].'">'.$fila['valorparametro'].' </option>'; 
					}
					echo '</select>'; 
				}
//			echo '</div>';
//			echo '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" >';
				if ($_SESSION['rif'])
				{
					// echo '<input type="hidden" name="numero" id="numero" value="'.$_POST['numero'].'">';
					// echo $_POST['numero'];
				}
				else
				{					
					echo '<label>N&uacute;mero</label>';
					echo '<input class="form-control" align="right" name="numero" type="text" id="numero" size="9" maxlength="9" value ="093773884" onchange="validarsinumero(this.value);"  title="se necesita el numero de cedula" onblur="ajax_call_rif()" required>';
				}
//			echo '</div>';
/*
			echo '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" >';
				echo 'Digito';
				if ($_POST['digito'])
				{
					echo '<input type="hidden" name="digito" id="digito" value="'.$_POST['digito'].'">';
					echo $_POST['digito'];
				}
				else {
				// echo '<select class="form-control" name="digito" id="digito" size="1">'; // onblur="ajax_call_rif()">';
				echo '<select class="form-control" name="digito" id="digito" size="1" onblur="ajax_call_rif()">';
				echo '<option value="0" selected >0 </option>'; 
				for ($elfactor=1; $elfactor < 10; $elfactor++)
					echo '<option value='.$elfactor.' >'.$elfactor.' </option>'; 
				echo '</select>'; 
				}
			echo '</div>';
*/

			echo '<div id="resultado"> </div>';
/*
			echo '</section>';
			echo '<section class="row">';

			echo '<div class="col-xs-12 col-sm-2 col-md-4 col-lg-4" >';
*/
				if ($_SESSION['rif'])
				{
					// echo '<input type="hidden" name="razon" id="razon" value="'.$_POST['razon'].'">';
					// echo $_SESSION['rif'];
				}
				else {
					echo '<label>Nombre/Raz&oacute;n Social</label>';
					echo '<input class="form-control" align="right" name="nombre" type="text" id="nombre" size="30" maxlength="100" value ="" readonly="readonly" title="se necesita un nombre">'; // required onfocus="refrescar_select();">'; onchange="validarnom_ape(this.value);" 
				}	
//			echo '</div>';
/*
			echo '<div class="col-xs-12 col-sm-2 col-md-1 col-lg-2" >';
				echo '<div id="btntramites" class="collapse">';
				// echo '<button class="btn btn-primary" value="VerTramites" name="VerTramites" onclick="cargarContenidoReloj(\'cargartributos.php?rif=V093773884\')" data-toggle="collapse" data-target="#mostrartributosadq">Ver Tr&aacute;mites Realizados ';
				// echo '<span class="badge"><div id="botontramites" name="botontramites">.</div></span></button>';
		//	 	echo '<a href="cargarContenidoReloj(\'cargartributos.php?rif=V093773884\')" class="btn btn-primary" data-toggle="collapse" data-target="#mostrartributosadq">Ver Tr&aacute;mites Realizados </a>';

					echo '<div class=\'link btn btn-primary\' onclick="cargarContenidoReloj(\'cargartributos.php?rif=V093773884\')">Ver <span class="badge"><div id="botontramites" name="botontramites"></span> Tr&aacute;mites </div>';
				// pulsa aqui para cargar <b>pagina3.php</b> dentro del div <b>contenido</b>. Se muestra un reloj mientras se carga.</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
*/
		// echo '</section>';
	}
	
	function normal()
	{ 
		$con = new ClassBasedeDatos();
		$con->conectar();
	?>
		<section class="row">
		<div class="form-group">
		<div class="col-xs-12 col-sm-3 col-md-2" >
		Tributo Solicitado
		</div>
		<div class="col-xs-12 col-sm-4 col-md-5" >
		<?php
			$sql="select *, concat(substr(concepto,1,70),'...') as cuento from campos where articulo < '12' order by articulo "; // limit 20";
			echo '<select class="form-control" name="tributo" id="tributo" size="1" onkeyUp="ajax_call_tributo()" onchange="ajax_call_tributo()">';
			$resultado=$con->consulta($sql);
			while ($fila2 = $con->fetch_assoc($resultado)) {
				echo '<option value="'.$fila2['idregistro'].'">'.$fila2['articulo'].'-'.$fila2['cuento'].'</option>'; 		
			}
			echo '</select> *'; 
		?>
		</div>
		</div>
		</section>

		<section class="row">
			<div class="col-xs-12 col-sm-4 col-md-4">
				Valor Actual de la UT
				<input class="form-control" align="right" name="valorut" type="text" id="valorut" size="10" maxlength="10" value ="" title="cantidad de ut" readonly="readonly" required>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4">
				Cantidad de UT
				<input class="form-control" align="right" name="ut" type="text" id="ut" size="10" maxlength="10" value ="" title="cantidad de ut" readonly="readonly" required>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 well">SubTotal
				<input class="form-control"  align="right" name="subtotal" type="text" id="subtotal" size="10" maxlength="10" value ="" title="cantidad de ut" readonly="readonly"required>
			</div>
		</section>


		<section class="row">
			<!-- <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#mostrable">
				Mostrar/Ocultar Cantidad (boton temporal ..... esto es para ser automatico)
			</button> -->
			<div id='mostrablerango' class="collapse-in">
				<div class="form-group col-xs-12 col-sm-4 col-md-2" id="cntminimo">
					Cantidad M&iacute;nima
					<input class="form-control" align="right" name="utminimo" type="text" id="utminimo" size="5" maxlength="5" value ="" title="Cantidad UT M&iacute;nimas" readonly disabled required>
				</div>
				<div class="form-group  col-xs-12 col-sm-4 col-md-2 " id="cntmaximo">
					Cantidad M&aacute;xima
					<input class="form-control" align="right" name="utmaximo" type="text" id="utmaximo" size="5" maxlength="5" value ="" title="Cantidad UT M&aacute;xima" readonly disabled required>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-3 ">
				<div id="descripcionmedida"> ...</div>
					<input align="right" type="hidden" name="medidasfijas" id="medidasfijas" size="20" maxlength="30" value ="" title="cantidad de ut" >
					<select class="form-control" name="requeridas" id="requeridas" size="1"  onchange="bs_ut(this.form);" onblur="bs_ut(this.form);" disabled>';
					</select> <br> 
				</div>
			</div>
		</section>

		<section class="row">
			<div id='mostrablecantidad' class="collapse">
			<div class="col-xs-12 col-sm-3 col-md-3 ">
			<div id="descripcionmedidac"> ...</div>
				<input align="right" type="hidden" name="medidasvariables" id="medidasvariables" size="20" maxlength="30" value ="" title="cantidad de ut" >
				<input class="form-control" align="right" name="requerido" type="text" id="requerido" size="10" maxlength="10" value ="0" title="cantidad de ut" disabled required  onchange="ValNumero(this, this.form);" onkeyUp="ValNumero(this, this.form); bs_ut(this.form);">
			</div>
			</div>
		</section>
		
<!--
		<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#control">
			Mostrar/Ocultar Variables de control (de caracter temporal ..... esto es solo para desarrollo)
		</button>
-->
		<div id='control' class="collapse-in well">
			<div class="col-xs-12 col-sm-4 col-md-8 ">
				Porcentaje Aplicado
				<input align="right" name="porcentajeaplicado" type="text" id="porcentajeaplicado" size="10" maxlength="10" value ="xxxx" title="cantidad de ut" required disabled>
				funcionalidad<input align="right" name="funcionalidad" type="text" id="funcionalidad" size="10" maxlength="10" value ="x" title="cantidad de ut" required>
				valor fraccion<input align="right" name="valorfraccion" type="text" id="valorfraccion" size="10" maxlength="10" value ="x" title="cantidad de ut" required>
				valor fijo<input align="right" name="valorfijo" type="text" id="valorfijo" size="10" maxlength="10" value ="x" title="cantidad de ut" required>
			</div>
		</div>
	<?php
	}
	
	function ahora()
{
	$fechactual="select now() as hoy";
	$fechactual=mysql_query($fechactual);
	$fechactual=mysql_fetch_assoc($fechactual);
	$fechactual=$fechactual['hoy'];
	return $fechactual;
}

	
	function agregar_tf()
	{
		$con = new ClassBasedeDatos();
		$con->conectar();
		if (($_POST['razon']!='') and ($_POST['subtotal'] > 0))
		{
			// echo 'estoy en agregar';
			$ahora=$this->ahora();
			$elrif=$_SESSION['rif']; // $_POST['nacionalidad'].$_POST['numero'].$_POST['digito'];
			$ip = $_SERVER['HTTP_CLIENT_IP'];
			if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}
			$comando="INSERT INTO timbresfiscales (fechatimbre, codigoente, riftimbre, nombretimbre, montobs, montout, fechavence, fechagenerada, ipgenerada, medidasfijas, requeridas, medidasvariables, requerido) VALUES 
			('$ahora', '".$_POST['tributo']."', '$elrif', '".$_POST['razon']."', '".$_POST['subtotal']."', '".$_POST['ut']."', DATE_ADD('".$ahora."', INTERVAL 30 DAY), '$ahora', '$ip', '".$_POST['medidasfijas']."', '".$_POST['requeridas']."', '".$_POST['medidasvariables']."', '".$_POST['requerido']."')";
			// echo $comando;
			$resul=$con->consulta($comando) or die('fallo '.$comando);
		}
		else 
		{
		//	echo ' no agregue razon = '.($_POST['razon']) . ' subtotal = '.$_POST['subtotal'] ;
			echo '<div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>Aviso!!!</h4> No se pudo agregar el requerimiento....
            </div>';
		}
		// $con->generarTablaTributos();
		// include_once('cargartributos.php');
		
		//////////////////
		$query="select count(riftimbre) as cuantos from timbresfiscales where riftimbre = '".$_SESSION['rif']."' group by riftimbre";
		// echo $query;
		$result=$con->consulta($query);
		$res=$con->fetch_assoc($result);
		if ($con->num_rows($result)>0)
		{
			echo "<form action='opciones.php' name='form1' id='form1' method='post'>";
			echo '<div class="col-xs-12 col-sm-2 col-md-2`">';
			// echo '<button class="btn btn-primary" value="VerTramites" name="VerTramites" onclick="cargarContenidoReloj(\'cargartributos.php?\')">Ver Tr&aacute;mites Realizados ';
			echo '<button class="btn btn-primary" value="VerTramites" name="VerTramites">Ver Tr&aacute;mites Realizados ';	
			echo '<span class="badge"><div id="botontramites" name="botontramites">'.$res['cuantos'].'</div></span></button>';
		//	 	echo '<a href="cargarContenidoReloj(\'cargartributos.php?rif=V093773884\')" class="btn btn-primary" data-toggle="collapse" data-target="#mostrartributosadq">Ver Tr&aacute;mites Realizados </a>';
			if (($_POST['razon']=='') or ($_POST['subtotal'] <= 0))
				echo '<button class="btn btn-danger" value="Regresar" name="Regresar">Regresar al Men&uacute;</button>'; 
			echo '<div>';
			echo '</form>';
		}
		//////////////////
		$con->desconectar();
	}
	
	function guardar_registro()
	{
		if (($_POST['numero']!='') and ($_POST['nombre'] !=' '))
		{
			$con = new ClassBasedeDatos();
			$con->conectar();
			$ahora=$this->ahora();
			$elrif=$_POST['nacionalidad'].$_POST['numero']; // .$_POST['digito'];
			$chequeo="select * from usuarios where rif_usuario = '$elrif'";
			$consulta=$con->consulta($chequeo);
			$registros = $con->num_rows($consulta);
			if ($registros > 0)
				echo '<h2>Disculpe... Ya se encuentra registrado</h2>';
			else 
			{			
				$ip = $_SERVER['HTTP_CLIENT_IP'];
				if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}
				$comando="INSERT INTO usuarios (rif_usuario, nombre_usuario, email, fechagenerada, ipgenerada, klave) VALUES 
				('$elrif', '".$_POST['nombre']."', '".$_POST['inputEmail']."', '".$ahora."', '$ip', MD5('".$_POST['inputPassword']."'))";
				if ($con->consulta($comando))
					echo '<h1>Gracias.... Se ha registrado satisfactoriamente</h1>';
				else 
					echo '<h2>Disculpe... hubo inconvenientes para almacenar la informaci&oacute;n. Intente mas tarde</h2>';
			}
		}
		else
		{			
			echo ' <h1>Disculpe... hubo inconvenientes para almacenar la informaci&oacute;n. Intente mas tarde</h1>';
		}
		// $con->desconectar();
	}

/*
	function vertramites()
	{
		$tributo->generarTablaTributos('');
		phpfinfo();
		
	}
	

	function generarTablaTributos($rifbuscar)
	{
		$con = new ClassBasedeDatos();
		$con->conectar();
		$valores='';

		$query="select ";
		foreach ($this->campos as $campos)
		{
			$valores.=$campos[campo].',';
		}
		$valores=rtrim($valores,',');
		$query.=$valores. ' from '.$this->tabla;
		$query.=' WHERE riftimbre = "'.$rifbuscar.'" ';
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
echo $query;
		$result = $con->execute_query($query);
//		echo 'query='.$query;

		//Cuenta el número total de filas de la tabla
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
//		} else {
//			?>
<!--
			<div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>Aviso!!!</h4> No hay datos para mostrar
            </div>
-->
			<?php

		}
		$con->desconectar();
		echo '<div id="termine">..............ooooooooooooooo</div>';
	}
	
*/	
}
	

/*

	if (isset($_POST['adquiRir']))
	{
		
	}


if ((isset($_POST['consulTar'])) or (isset($_POST['adquiRir'])))
{
	
}


if ((isset($_POST['method'])) && (isset($_GET['method'])!=''))
{
	echo 'metodo '.$_GET['method'];
	switch ($_GET['method'])
	{
		default:
			$crud->generarTabla();
			break;
		case agregar:
			$crud->agregarRegistro();
			break;
		case eliminar:
			$crud->eliminarRegistro();
			break;
		case modificar:
			echo 'voy';
			$crud->modificarRegistro();
			echo 'regreso';
		break;
	}
}
else
$crud->generarTabla();


/*
echo $crud->header;
$crud->tabla = 'timbresfiscales';
$crud->id	= 'idregistro';
$crud->campos = array(
	array('campo'=>'idregistro',
		'tipo'=>'NoMostrar',
		'titulo'=>'idregistro',
		'required'=>'required'),
	array('campo'=>'fechatimbre',
		'tipo'=>'text',
		'titulo'=>'Generado el',
		'required'=>'required'),
	array('campo'=>'montobs',
		'tipo'=>'text',
		'titulo'=>'Monto Bs',
		'required'=>'required'),
array('campo'=>'montout',
		'tipo'=>'text',
		'titulo'=>'Cantidad UT',
		'required'=>'required')
	);
		
if ((isset($_GET['method'])) && (isset($_GET['method'])!=''))
{
	echo 'metodo '.$_GET['method'];
	switch ($_GET['method'])
	{
		default:
			$crud->generarTabla();
			break;
		case agregar:
			$crud->agregarRegistro();
			break;
		case eliminar:
			$crud->eliminarRegistro();
			break;
		case modificar:
			echo 'voy';
			$crud->modificarRegistro();
			echo 'regreso';
		break;
	}
}
else
$crud->generarTabla();
*/

?>
