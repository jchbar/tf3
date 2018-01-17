var xmlhttp;
// =false;

// if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
//  xmlhttp = new XMLHttpRequest();
// }
	var handleResponse = function (status, response) {
		alert(response)
	}


function ajax_call_rif() {

	xmlhttp= GetXmlHttpObject(); // new XMLHttpRequest();// GetXmlHttpObject();
	if (xmlhttp==null)
	  {
		  alert ("Browser does not support HTTP Request");
	  return;
	  }
	 var linea='rifjson.php?rif=' + document.getElementById('nacionalidad').value+ document.getElementById('numero').value+document.getElementById('digito').value;
	//var linea='http://localhost/tf/rifjson.php?rif=V093773884' ;
	// alert(linea);
	xmlhttp.onreadystatechange=cambiorif;

//	xmlhttp.open("GET", linea, true);

	if ("withCredentials" in xmlhttp){
        // XHR has 'withCredentials' property only if it supports CORS
		xmlhttp.open("GET", linea, true);
    } else if (typeof XDomainRequest != "undefined"){ // if IE use XDR
        xmlhttp = new XDomainRequest();
		xmlhttp.open("GET", linea);
    } else {
        xmlhttp= null;
    }

	
/*
    try {
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.setRequestHeader("Accept", "text/xml, application/xml, text/plain");
	}
	else 
	{
        window.alert('error' + ex.toString());		
	}
*/
//----------
	xmlhttp.send(null)
//	return false;
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
if ((xmlhttp.readyState==4)) { // && (xmlhttp.status == 200)) {
	var xmlDoc=xmlhttp.responseXML;
	
	// var parser = new DOMParser();
	// var xmlDoc = parser.parseFromString(xmlhttp.responseText, "application/xml"); 

	// document.getElementById("razon").value = new XMLSerializer().serializeToString(xmlDoc);
	
	document.getElementById('resultado').innerHTML = "" ;// +xmlDoc.getElementsByTagName("nombre")[0].childNodes[0].nodeValue;
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
	// alert(xmlDoc.getElementsByTagName("nombreseniat")[0].childNodes[0].nodeValue)
	document.getElementById("razon").value=xmlDoc.getElementsByTagName("nombreseniat")[0].childNodes[0].nodeValue;
	// alert('3')
	}
//else   document.getElementById('resultado').innerHTML = "<img src=\"imagenes/animadas/cargando.gif\" />";
else
	document.getElementById('resultado').innerHTML = 'Buscando informaci&oacuten ' +  document.getElementById('nacionalidad').value+ document.getElementById('numero').value+document.getElementById('digito').value + "<img src=\"imagenes/animadas/cargando.gif\" />";;
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

