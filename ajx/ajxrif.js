var xmlhttp;
// =false;

// if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
//  xmlhttp = new XMLHttpRequest();
// }
/*
	var handleResponse = function (status, response) {
		alert(response)
	}
*/

function ajax_call_rif() {

	xmlhttp= GetXmlHttpObject(); // new XMLHttpRequest();// GetXmlHttpObject();
	if (xmlhttp==null)
	  {
		  alert ("Browser does not support HTTP Request");
	  return;
	  }
//	  alert('-1')
	 var linea='ajx/revisarrif.php?RIF=' + document.getElementById('nacionalidad').value+ document.getElementById('numero').value+document.getElementById('digito').value;
//	 var linea='ajx/resultado.xml';
	// var linea='http://localhost/tf/rifjson.php?rif=V093773884' ;
// alert('0')
	xmlhttp.onreadystatechange=cambiorif();
// alert('1')
	xmlhttp.open("GET", linea, true);

/*
	if ("withCredentials" in xmlhttp){
        // XHR has 'withCredentials' property only if it supports CORS
		xmlhttp.open("GET", linea, true);
    } else if (typeof XDomainRequest != "undefined"){ // if IE use XDR
        xmlhttp = new XDomainRequest();
		xmlhttp.open("GET", linea);
    } else {
        xmlhttp= null;
    }
*/
//	alert(linea);

	

/*
    try {
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
//		xmlhttp.setRequestHeader("Accept", "text/xml, application/xml, text/plain");
	}
	catch (ex)
	{
        window.alert('error' + ex.toString());		
	}
*/
//----------
	xmlhttp.send(null)
//	return false;
//	mostrar_tramites_v1();
// alert('a')
}

function cambiorif() {
//	var handleStateChange = function () {
/*
	switch (xmlhttp.readyState) 
	{
      case 0 : // UNINITIALIZED
      case 1 : // LOADING
      case 2 : // LOADED
      case 3 : // INTERACTIVE
      break;
      case 4 : // COMPLETED
      handleResponse(xmlhttp.status, xmlhttp.responseText);
      break;
      default: alert("error");
		}
	}
*/
//	alert(xmlhttp.readyState +' /////' +xmlhttp.status);
if ((xmlhttp.readyState==4)) { 
//if (xmlhttp.status == 200) 
{
	var xmlDoc=xmlhttp.responseXML;
	
//	var foros=xmlDoc.getElementsByTagName("resultadosseniat");	
//	alert(foros[0].getElementsByTagName("razon")[0].childNodes[0].nodeValue)
/*
	for(var i=0;i<foros.length;i++)
{
	// Del elemento foro, obtenemos del primer elemento denominado "titulo"
	// el valor del primer elemento interno
	titulo=foros[i].getElementsByTagName("razon")[0].childNodes[0].nodeValue
 
	url=foros[i].getElementsByTagName("nrotramites")[0].childNodes[0].nodeValue
 
	document.write("<div>");
		document.write("<span>");
		document.write(titulo);
		document.write("</span><span>");
		document.write("<a href='"+url+"' target='_blank'>"+url+"</a>");
		document.write("</span>");
	document.write("</div>");
}
*/
	

/*
	var mensaje= xmlDoc.getElementsByTagName('nombreseniat')[0];
    var textoMensaje=mensaje.childNodes[0].nodeValue;
	alert(textoMensaje)
*/			
	// var xmlDoc= xmlDoc.getElementById("resultadosseniat").firstChild.nodeValue;
	
	// var parser = new DOMParser();
	// var xmlDoc = parser.parseFromString(xmlhttp.responseText, "application/xml"); 

	// document.getElementById("razon").value = new XMLSerializer().serializeToString(xmlDoc);
	
	document.getElementById('resultado').innerHTML = ""; // + xmlDoc.getElementsByTagName("nombreseniat")[0].childNodes[0].nodeValue;
	// alert("tengo problemas para mostrar la respuesta"+xmlDoc)
/*
	txt = "";
	x = xmlDoc.getElementsByTagName("resultados_seniat");
	for (i = 0; i < x.length; i++) {
		txt += x[i].childNodes[0].nodeValue + "<br>";
	}
	document.getElementById("resultado").innerHTML = txt;
*/
	// document.getElementById("razon").value= xmlDoc.getElementsByTagName("nombre")[0].childNodes[0].nodeValue;
	// alert(xmlDoc.getElementsByTagName("nombreseniat")[0].childNodes[0].nodeValue);
	 document.getElementById("razon").value="falta retornar valor correcto " ; // xmlDoc.getElementsByTagName("nombreseniat")[0].childNodes[0].nodeValue;
	document.getElementById("razon").value= xmlDoc.getElementsByTagName("nombreseniat")[0].childNodes[0].nodeValue;
 //alert('1')
//	document.getElementById("razon").value= xmlDoc.getElementsByTagName("nombreseniat")[0].textContent; // [0].childNodes[0].nodeValue;
// 	alert('2')
	cuantos=14;
	if (xmlDoc.getElementsByTagName("code_result")[0].childNodes[0].nodeValue == 1)
	{
//		alert ('1');
		document.getElementById("btntramites").style.display="block";		
		document.getElementById("botontramites").innerHTML=xmlDoc.getElementsByTagName("nrotramites")[0].childNodes[0].nodeValue;;
	}
	 // alert('3')
	}
}
//else   document.getElementById('resultado').innerHTML = "<img src=\"imagenes/animadas/cargando.gif\" />";
else
	document.getElementById('resultado').innerHTML = 'Buscando informaci&oacuten ' +  document.getElementById('nacionalidad').value+ document.getElementById('numero').value+document.getElementById('digito').value + "<img src=\"ajx/imagenes/animadas/cargando.gif\" />";
	// document.getElementById('resultado').innerHTML = 'estatus '+xmlhttp.status+'Buscando informaci&oacuten ' +  document.getElementById('nacionalidad').value+ document.getElementById('numero').value+document.getElementById('digito').value + "<img src=\"imagenes/animadas/cargando.gif\" />";;
	//document.getElementById('resultado').innerHTML = 'estatus ' + xmlhttp.status + ' estatus ' + xmlhttp.responseXML  ;
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

