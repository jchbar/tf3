<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
//echo 'estoy en buscar tributos';

?>

<head>
<?php include('head.html'); 
// script language="javascript" src="validaciones.js" type='text/javascript'></script>
// script type="text/javascript" src="ajx/select_dependientes_3_niveles.js"></script>
?>

<script src="ajxrif.js" type="text/javascript"></script>
<script src="ajx/mostrartributos.js" type="text/javascript"></script>

<script language="JavaScript" type="text/javascript">
function Solo_Numerico(variable){
        Numer=parseFloat(variable);
        Numer=variable;
        if(isNaN(Numer)){
        	alert('Debe colocar solo numeros y utilizar el punto (.) como separador de decimales');
        	return "";
        }
        return Numer;
    }
function ValNumero(Control, Formulario){
    Control.value=Solo_Numerico(Control.value);
//	bs_ut(Formulario);
}

function bs_ut(Formulario)
{
	Formulario.subtotal.value = 0.00;
	numero=eval(Formulario.requerido.value); //  / eval(F.unidadt.value);
	// //F.uts.value = numero;
	// F.uts.value = numero.toFixed(4);
	
	var bs = eval(Formulario.requerido.value);
	var funcionalidad = eval(Formulario.funcionalidad.value);
	if (funcionalidad == 2)
	{
		Formulario.subtotal.value = eval(Formulario.requerido.value * (Formulario.porcentajeaplicado.value / 100));
	}

	if (funcionalidad == 3)
	{
		var seleccion = Formulario.requeridas.options;
		
		seleccion=Formulario.requeridas.selectedIndex;
		Formulario.subtotal.value = eval(document.getElementById('requeridas').options[seleccion].value * (Formulario.valorut.value));
//		document.getElementById('lascuotas').options[selIndex].value
/*
		if ((Formulario.requerido.value < Formulario.utminimo.value) || (Formulario.requerido.value > Formulario.utmaximo.value))
			alert(Formulario.requerido.value+ ' / '+Formulario.utminimo.value+'Atencion.... Debe estar dentro del rango permitido'+Formulario.utmaximo.value);
			// alert('Atencion.... Debe estar dentro del rango permitido');
			*/
	}

	if (funcionalidad == 4)
	{
		var unidades = 0;
		var restantes = 0;
		var resto = 0;
		var base = eval(Formulario.valorut.value) * eval(Formulario.ut.value);
		if (eval(Formulario.valorfraccion.value) == 0)
			base = eval(Formulario.valorut.value) * eval(Formulario.ut.value) * eval(Formulario.requerido.value);

		if ((Formulario.valorfraccion.value > 0) && (Formulario.requerido.value > 0))
		{
			restantes = eval(Formulario.requerido.value) - 1;
			if (restantes < 0)
				restantes = 0;
			base = eval(Formulario.valorut.value) * eval(Formulario.ut.value);
			resto = (restantes *  (Formulario.valorfraccion.value * Formulario.valorut.value));
			Formulario.subtotal.value = eval(base + resto);
		}
		Formulario.subtotal.value = (base + resto);

		var longstring=""+bs+"";
		var brokenstring=longstring.split(".");
		var length = brokenstring[1].length;
		if(length > 2)
		{
			//	F.requerido.value = F.requerido.toFixed(2);
		
			/*var decimales = parseInt(''+brokenstring[1]+'').toPrecision(3);
			var strLen = decimales.length;
			decimales = decimales.slice (0, strLen-1);
			F.bs.value = brokenstring[0]+'.'+decimales;*/
	
			alert('Atencion.... Solo m&acute;ximo dos decimales');
		}
	}
}

</script>


</head>
<body>

<?php
include_once 'dbconfig.php';
include ('header.html'); 
echo 'falta revisar si esta en mantenimiento<br>';
echo 'la idea es que lo no necesario en ese momento este oculto y aparezca cuando se requiera, <br>por ejemplo el 10.01.c aparezca Indique Monto de la Obra y se coloque el 1%<br>';
echo 'igual con la minima y maxima';
// echo '        	    <button class="btn btn-primary" value="consultar" name="consultar" >consultar tributo</button>';
/*
echo '<div class="container-fluid">';
echo '<div class="col-xs-12 col-sm-8 col-md-9">';
echo '<div class="signin-form">';
echo '<div class="container">';
*/
?>
<div class="container">
<?php
	extract($_POST);
	echo '<div class="hidden-xs col-xs-12 col-sm-8 col-md-6">'; // hidden-sm 
	echo '<h1>';
	if ($_post['consultar']) echo 'pidio consulta';
		else if ($_post['adquirir']) echo 'pidio comprar';
		else if (($_post['quieroser'])) echo 'preguntar';
	echo '</h1>';
?>
   </div>

<form action='buscartributos.php' name='form1' id='form1' method='post'> <!-- //  onsubmit='return validadatos(form1)'> // hidden-xs div class="col-xs-12 col-sm-8 col-md-6"> --> ;
<?php
	if ($_POST['adquiRir']) 
	{
		?>
		<section class="row">
		<div class="form-group">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2" >
		Nacionalidad
		<?php 
		$comando="select * from configuracion where nombreparametro = 'nacionalidad' order by valorparametro" ;
		$res=mysql_query($comando);
		echo '<select class="form-control" name="nacionalidad" id="nacionalidad" size="1">';
		while ($fila = mysql_fetch_assoc($res)) {
			echo '<option '.($fila['valorparametro']=='V'?' selected="selected" ':'') .' value="'.$fila['valorparametro'].'">'.$fila['valorparametro'].' </option>'; 
		}
		echo '</select>'; 
		?>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2" >
		Cedula
		<input class="form-control" align="right" name="numero" type="text" id="numero" size="8" maxlength="8" value ="09377388" onchange="validarsinumero(this.value);"  title="se necesita el numero de cedula" required>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2" >
		Digito
		<?php 
		//echo '<select class="form-control" name="digito" id="digito" size="1">'; // onblur="ajax_call_rif()">';
		echo '<select class="form-control" name="digito" id="digito" size="1" onblur="ajax_call_rif()">';
		echo '<option value="0" selected >0 </option>'; 
		for ($elfactor=1; $elfactor < 10; $elfactor++)
			echo '<option value='.$elfactor.' >'.$elfactor.' </option>'; 
		echo '</select>'; 
		// <button type="button" onclick="ajax_call_rif(); return false;">CHange Content</button>
		?>
		
		<div id="resultado">
		el resultado
		</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" >
		<?php
		echo 'Nombre/Raz&oacute;n Social';
		echo '<input class="form-control"  align="right" name="razon" type="text" id="razon" size="30" maxlength="100" value ="" onchange="validarnom_ape(this.value);" title="se necesita un nombre">'; // required onfocus="refrescar_select();">';
		?>
		</div>
		</div>
		</section>
		<?php
	}
?>
<section class="row">
	<div class="form-group">
	<div class="col-xs-12 col-sm-4 col-md-2" >
	Tributo Solicitado
	</div>
	<div class="col-xs-12 col-sm-4 col-md-5" >
	<?php
		$sql="select *, concat(substr(concepto,1,50),'...') as cuento from campos order by articulo"; // limit 20";
		echo '<select class="form-control" name="tributo" id="tributo" size="1" onkeyUp="ajax_call_tributo()" onchange="ajax_call_tributo()">';
		$resultado=mysql_query($sql);
		while ($fila2 = mysql_fetch_assoc($resultado)) {
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
	<input class="form-control" align="right" name="valorut" type="text" id="valorut" size="10" maxlength="10" value ="" title="cantidad de ut" disabled readonly required>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-4">
		Cantidad de UT
		<input class="form-control" align="right" name="ut" type="text" id="ut" size="10" maxlength="10" value ="" title="cantidad de ut" readonly disabled required>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-4 well">SubTotal
	<input class="form-control"  align="right" name="subtotal" type="text" id="subtotal" size="10" maxlength="10" value ="" title="cantidad de ut" disabled required>
</section>


<section class="row">
<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#mostrable">
  Mostrar/Ocultar Cantidad (boton temporal ..... esto es para ser automatico)
</button>
	<div id='mostrable' class="well collapse">
	<div class="col-xs-12 col-sm-4 col-md-3" id="cntminimo">
		Cantidad M&iacute;nima
		<input class="form-control" align="right" name="utminimo" type="text" id="utminimo" size="10" maxlength="10" value ="" title="Cantidad UT M&iacute;nimas" readonly disabled required>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-3 " id="cntmaximo">
		Cantidad M&aacute;xima
		<input class="form-control" align="right" name="utmaximo" type="text" id="utmaximo" size="10" maxlength="10" value ="" title="Cantidad UT M&aacute;xima" readonly disabled required>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-6 ">Indique <input align="right" name="descripcionmedida" type="text" id="descripcionmedida" size="20" maxlength="30" value ="" title="cantidad de ut" readonly disabled required>
	<input class="form-control" align="right" name="requerido" type="text" id="requerido" size="10" maxlength="10" value ="0" title="cantidad de ut" disabled required  onchange="ValNumero(this, this.form);" onkeyUp="ValNumero(this, this.form); bs_ut(this.form);">
	<select class="form-control" name="requeridas" id="requeridas" size="1"  onchange="bs_ut(this.form);" onblur="bs_ut(this.form);" disabled>';
	</select> <br> 
	</div>
	
</section>
<button class="btn btn-success" value="Agregar" name="AgregarT" >Agregar Tributo a la Lista</button>

<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#control">
  Mostrar/Ocultar Variables de control (de caracter temporal ..... esto es solo para desarrollo)
</button>
	<div id='control' class="collapse well">
	<div class="col-xs-12 col-sm-4 col-md-8 ">
	<fieldset>
	Porcentaje Aplicado
	<input align="right" name="porcentajeaplicado" type="text" id="porcentajeaplicado" size="10" maxlength="10" value ="xxxx" title="cantidad de ut" required disabled>
	funcionalidad<input align="right" name="funcionalidad" type="text" id="funcionalidad" size="10" maxlength="10" value ="" title="cantidad de ut" required>
	valor fraccion<input align="right" name="valorfraccion" type="text" id="valorfraccion" size="10" maxlength="10" value ="" title="cantidad de ut" required>
	valor fijo<input align="right" name="valorfijo" type="text" id="valorfijo" size="10" maxlength="10" value ="" title="cantidad de ut" required>
	</fieldset>
	</div>
	</div>

<!--
	<td>
	<a href="#porapl" class="btn btn-primary" data-toggle="collapse">mostrar</a>
	<div id="porapl" class="collapse">
		div id="porapl"class="well">
			td class="well">porcentaje aplicado</td
			td class="well">aa<input align="right" name="porcentajeaplicado" type="text" id="porcentajeaplicado" size="10" maxlength="10" value ="xxxx" title="cantidad de ut" readonly required></td
		/div>
	</div>
	</td>
	</td>
-->

<!--
	<td>
	a href="#porapl" class="btn btn-primary" data-toggle="collapse">mostrar</a>
	<div id="porapl" class="col-xs-12 well">
			<td class="hide">porcentaje aplicado</td>
			<td class="hide">aa<input align="right" name="PorcentajeAplicado" type="text" id="PorcentajeAplicado" size="10" maxlength="10" value ="xxxx" title="cantidad de ut" readonly required></td>
	</div>
	</td>
-->

	</tr>
<section class="row">
	<div class="col-xs-12 col-sm-4 col-md-6">
<?php
	echo '<td><input align="right" name="unidades" type="text" id="unidades" size="10" maxlength="10" value ="" title="cantidad de ut" required></td>';
echo '</form>';
?>	
</div>
</section>
</div>

</body></html>
