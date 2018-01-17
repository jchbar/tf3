var xmlhttp;
// =false;

// if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
//  xmlhttp = new XMLHttpRequest();
// }

function ajx_rev_mail() {
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
		  alert ("Browser does not support HTTP Request");
	  return;
	  }
//	var selIndex = document.getElementById('lascuotas').options[document.getElementById('lascuotas').selectedIndex].value;
//	var selIndex = document.getElementById("lascuotas").options[document.getElementById("lascuotas").selectedIndex].value; 
//	var selIndex = document.getElementById('cedula').value;
//	comboValue = document.getElementById('lascuotas').options[selIndex].value;
// alert('1');
	var linea='ajx/revisarmail.php?email =' + document.getElementById('inputEmail').value ; // +'&pp=' + document.getElementById('pwdvieja').value;
//	alert(linea);
						
						// +  document.getElementById('monpre_sdp').value;
						// document.getElementById('lascuotas');
 	// alert(linea);
	xmlhttp.onreadystatechange=cambiopwd;
	xmlhttp.open("GET", linea, true);
//----------
/*
//setup the headers
    try {
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.setRequestHeader("Accept", "text/xml, application/xml, text/plain");
    } catch ( ex ) {
        window.alert('error' + ex.toString());
    }

*/
//----------
	xmlhttp.send(null)
//	return false;
}


function cambiopwd() {
//	alert('a')
document.getElementById('resultado').innerHTML = ""; // + xmlDoc.getElementsByTagName("nombreseniat")[0].childNodes[0].nodeValue;
if (xmlhttp.readyState==4) {
	xmlDoc=xmlhttp.responseXML;
	// alert('obtenido '+xmlDoc.getElementsByTagName("obtenido")[0].childNodes[0].nodeValue);
	if (xmlDoc.getElementsByTagName("obtenido")[0].childNodes[0].nodeValue=="1")
	{
		document.getElementById("inputEmail").value="";
		document.getElementById("inputEmailConfirm").value="";
		alert("Email ya se encuentra registrado... Debe utilizar uno diferente");
	}
/*
	if (xmlDoc.getElementsByTagName("obtencion_local")[0].childNodes[0].nodeValue==1)
	{
//		alert("activo");
		document.getElementById("ingresar").value="Modificar";
		document.getElementById("eliminar").disabled=false;

	}

//	document.getElementById("apellido").value=xmlDoc.getElementsByTagName("apellido")[0].childNodes[0].nodeValue;
*/
	}
else
	document.getElementById('resultado').innerHTML = 'Buscando informaci&oacuten ' +  document.getElementById('inputEmail').value+ "<img src=\"ajx/imagenes/animadas/cargando.gif\" />";

}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
//	  alert('a');
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
//	  alert('b');
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

////////////////////////
