/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//funciones basicas

function mostrar(accion) {
    if(accion==1)
        document.getElementById('busqueda_avanzada').style.display='block';
    else
        document.getElementById('busqueda_avanzada').style.display='none';
}

function tipo_cliente() {

    var tipo_cliente = document.getElementById('id_tipo_cliente').value;

   alert(tipo_cliente); 
}


