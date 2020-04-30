function createXMLHTTP(){
	var ajax;
	try {
		ajax = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	catch(e) {
		try{
			ajax = new ActiveXObject("Msxml2.XMLHTTP");
			alert(ajax);
			}
		catch(ex) {
			try{
				ajax = new XMLHttpRequest();
			}
			catch(exc) {
				alert("Esse browser não tem recursos para uso do Ajax");
				ajax = null;
			}
		}
		return ajax;
	}

	var arrSignatures = ["MSXML2.XMLHTTP.5.0", "MSXML2.XMLHTTP.4.0","MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP","Microsoft.XMLHTTP"];
	for (var i=0; i < arrSignatures.length; i++){
		try{
			var oRequest = new ActiveXObject(arrSignatures[i]);
			return oRequest;
    	} 
		catch (oError){
		}
	}
	throw new Error("MSXML não está instalado em seu sistema.");
}

function SubmitAjax(prmMetodo,prmAcao,prmForm,prmDivDestino){



//FUNCAO AJAX QUE PEGA TODOS OS ITENS DE UM DETERMINADO FORMULÁRIO
	var Div; 
	var StringUrl;
	StringUrl = "";
	
	ObjDiv = "document.getElementById('" + prmDivDestino + "')";
	Div = eval(ObjDiv);
	//alert(ObjDiv);
	Div.innerHTML = '<img src="/romaneio/view/img/10.gif">';
	
	if(prmForm != ''){
		ObjForm = "document.getElementById('" + prmForm + "')";
		//alert(ObjForm);
		ObjForm = eval(ObjForm);
		//alert(ObjForm.elements.length);
		//GERA A STRING URL PARA TRANSMITIR - CAMPO1=VALOR&CAMPO2=VALOR&
		for ( var i = 0; i < ObjForm.elements.length; i++ ) {
			//if(!ObjForm.elements[i].disabled){
				if((ObjForm.elements[i].type == "checkbox") || (ObjForm.elements[i].type == "radiobox") || (ObjForm.elements[i].type == "radio")){
					if (ObjForm.elements[i].checked == true) {
						StringUrl = StringUrl + ObjForm.elements[i].name + '=' + ObjForm.elements[i].value + '&';
					}
				}else{
					StringUrl = StringUrl + ObjForm.elements[i].name + '=' + ObjForm.elements[i].value + '&';
				}
				//alert(StringUrl);
			//}
		}
	}		

	var NovoStringUrl;
	NovoStringUrl = "";
	//NovoStringUrl = prmAcao + "?";
	for (var i=0;i<StringUrl.length;i++){
		NovoStringUrl += encodeURI(StringUrl.substring(i,eval(i+1)).replace(" ","!@!"));
	}
	//alert(NovoStringUrl);
	var oHTTPRequest = createXMLHTTP(); 
	
	//alert(prmAcao);
	oHTTPRequest.open(prmMetodo, prmAcao, true);
	oHTTPRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	oHTTPRequest.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
	oHTTPRequest.setRequestHeader("Pragma", "no-cache");

	oHTTPRequest.onreadystatechange=function(){
	//alert(oHTTPRequest.readyState + ' ' + oHTTPRequest.responseText);
	
		if (oHTTPRequest.readyState==4){
				
				if(oHTTPRequest.status == 200){
					Div.innerHTML = oHTTPRequest.responseText;
				}else{
					alert(oHTTPRequest.statusText);
				}
			//alert(oHTTPRequest.responseText);	
			Div.innerHTML = oHTTPRequest.responseText;
			//alert(Div.innerHTML);
		}
	}
	oHTTPRequest.send(NovoStringUrl);	
}