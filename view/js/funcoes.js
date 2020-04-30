// JavaScript Document

function bloquearEnter() {
    if (event.keyCode == 13) {
        event.keyCode = 0;
        return false;
    }
    return true;
}

function marcarTodos(id, form) {
    objId = eval(document.getElementById(id));
    objForm = eval(document.getElementById(form));
//	alert(objForm.elements.length);
    if (objId.checked) {
        for (i = 0; i < objForm.elements.length; i++)
            if (objForm.elements[i].type == "checkbox")
                objForm.elements[i].checked = 1;
    } else {
        for (i = 0; i < objForm.elements.length; i++)
            if (objForm.elements[i].type == "checkbox")
                objForm.elements[i].checked = 0;
    }
//	alert(objForm.elements.length);
//	objClass.checked = true;

}


//function validaFormMarca(nome){
//	if (nome == 'Excluir') {
//		var r = confirm("Tem certeza que deseja excluir?");
//		if (r == true) {
//			return true;	
//		} else {
//			return false;
//		}	
//	} else {
//		if (document.getElementById('pfDesMarca').value == "") {
//			alert('Digite o nome da marca!')	;
//			document.getElementById('pfDesMarca').focus();
//			return false;
//		}
//	} 
//}

function redirecionar(url) {
    location.href = url;
}

function alerta() {
    alert('alerta de teste');
}

function pedidoAjax() {
    SubmitAjax('post', 'OSDadosFinanceirosResultadoCalculoAjax.php', 'formOS', 'divValorDasParcelas');
}

function confirmaEncerrar(cod, descricao) {
    return confirm("Confirma a finalização do Romaneio:\nCód: " + cod + "\nDescrição: " + descricao);

}

function confirmaEncerrarFuncao(cod, descricao, funcao) {
    if (confirm("Confirma a finalização do Romaneio:\nCód: " + cod + "\nDescrição: " + descricao)) {
        f = eval("document." + funcao);
        f.submit();
        return true;
    } else {
        return false;
    }


}

function confirmaReabrir(cod, descricao) {
    return confirm("Confirma a REABERTURA do Romaneio:\nCód: " + cod + "\nDescrição: " + descricao);
}

function excluirPedido(){
    return confirm("Tem certeza que deseja excluir este pedido\nESTA OPERAÇÃO NÃO SERÁ DESFEITA");
}

function confirmaExcluir(){
    return confirm("Tem certeza de que deseja EXCLUIR este Romaneio. Esta operação não poderá ser desfeita.");
}


