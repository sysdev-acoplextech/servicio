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
}

function add_pax() {
    var nombre_pax = document.getElementById('pasajero-nombre_apellido').value;
    var telefono_pax = document.getElementById('telefono_pax').value;
    
    var fecha_pax = document.getElementById('pasajeroservicio-fecha').value;
    var hora_pax = document.getElementById('w1').value;

    var origen_pax = document.getElementById('pasajeroservicio-origen').value;
    var destino_pax = document.getElementById('pasajeroservicio-destino').value;
    var num_pax = document.getElementById('num_pax').value;


    //Enviamos los valores
    document.getElementById('nombre'+num_pax).value=nombre_pax;
    document.getElementById('telefono'+num_pax).value=telefono_pax;
    document.getElementById('fecha'+num_pax).value=fecha_pax;
    document.getElementById('hora'+num_pax).value=hora_pax;
    document.getElementById('origen'+num_pax).value=origen_pax;
    document.getElementById('destino'+num_pax).value=destino_pax;

    //Limpiamos las variables
    document.getElementById('pasajero-nombre_apellido').value='';
    document.getElementById('telefono_pax').value='';
    document.getElementById('pasajeroservicio-origen').value='';

    document.getElementById('resumen_pasajeros').style.display='block'; 
    document.getElementById('pax_'+num_pax).style.display='block'; 
    document.getElementById('num_pax').value=parseInt(num_pax)+1;
   
}

function opendiv(div){ 
    switch (div) {
        case 'servicio':
            document.getElementById('servicio_div').style.display='block'; 
            document.getElementById('cliente_div').style.display='none'; 
            document.getElementById('pasajeros_div').style.display='none'; 
            document.getElementById('gestionar_div').style.display='none'; 
            break;
        case 'cliente':
            document.getElementById('cliente_div').style.display='block'; 
            document.getElementById('servicio_div').style.display='none'; 
            document.getElementById('pasajeros_div').style.display='none'; 
            document.getElementById('gestionar_div').style.display='none'; 
            break;
        case 'pasajero':
            document.getElementById('pasajeros_div').style.display='block'; 
            document.getElementById('servicio_div').style.display='none'; 
            document.getElementById('cliente_div').style.display='none'; 
            document.getElementById('gestionar_div').style.display='none'; 
            break;
        case 'gestionar':
            document.getElementById('pasajeros_div').style.display='none'; 
            document.getElementById('servicio_div').style.display='none'; 
            document.getElementById('cliente_div').style.display='none'; 
            document.getElementById('gestionar_div').style.display='block'; 

            break;

            
    }
    
}

function suma_cantidad(dato){
    var cantidad= document.getElementById('cant_v'+dato).value;
    var monto= document.getElementById('monto_v'+dato).value;
    var subtotal= document.getElementById('subtotal_v'+dato).value;

    var acumulado=document.getElementById('monto').value;

    var valor= 0;
    var valor_suma= 0;

    valor= parseFloat(monto)*parseFloat(cantidad);
    valor = valor.toFixed(2);
    valor_suma= parseFloat(valor)-parseFloat(subtotal); 
    document.getElementById('subtotal_v'+dato).value= valor;
    valor=parseFloat(acumulado)+ parseFloat(valor_suma);
    valor = valor.toFixed(2);
    document.getElementById('monto').value=parseFloat(valor);
    document.getElementById('view_monto').innerHTML = valor + "$";
}

function quitar(dato){
    var subtotal=document.getElementById('subtotal_v'+dato).value;
    var monto=document.getElementById('monto').value;
    var view_monto=document.getElementById('view_monto').value;

    // Resto el monto
    monto= parseFloat(monto)-parseFloat(subtotal);
    monto = monto.toFixed(2);
    document.getElementById('monto').value=monto;
    document.getElementById('view_monto').innerHTML = monto + "$";
    document.getElementById('subtotal_v'+dato).value=0;
    document.getElementById('cant_v'+dato).value=0;

    switch (dato) {
        case 1:
            document.getElementById('vs_maleta').style.display = 'none';
            break;
        case 2:
            document.getElementById('vs_pax').style.display = 'none';
            break;
        case 3:
            document.getElementById('vs_hora_espera').style.display = 'none';
            break;
        case 4:
            document.getElementById('vs_aeropuerto').style.display = 'none';
            break;
        case 5:
            document.getElementById('vs_silla').style.display = 'none';
            break;
        case 6:
            document.getElementById('vs_encomienda').style.display = 'none';
            break;
        case 7:
            document.getElementById('vs_mascota').style.display = 'none';
            break;
    }

    //Limpiamos la variable


}

function enviarDato(dato, dato1) { 

    var km = document.getElementById('km').value;

    if (km == ''){
        alert("Debe ingresar la cantidad de Km del Servicio para generar el cálculo");
        document.getElementById('km').focus();
        return false;
    }else{
        var acumulado = document.getElementById('monto').value;

            var suma = 0;

            switch (dato) {
                case '1':
                    document.getElementById('vs_maleta').style.display = 'block';
                    document.getElementById('variable1').value = dato;
                    document.getElementById('monto_v1').value = dato1;
                    document.getElementById('subtotal_v1').value = dato1;
                    document.getElementById('desc_variable1').innerHTML = "Equipaje adicional";
                    suma = parseFloat(acumulado) + parseFloat(dato1);
                    suma = suma.toFixed(2);
                    document.getElementById('monto').value = suma;
                    document.getElementById('view_monto').innerHTML = parseFloat(suma) + "$";
                // document.getElementById('view_precio').innerHTML = dato1;
                    break;

                    case '2':
                    document.getElementById('vs_pax').style.display = 'block';
                    document.getElementById('variable2').value = dato;
                    document.getElementById('monto_v2').value = dato1;
                    document.getElementById('subtotal_v2').value = dato1;
                    document.getElementById('desc_variable2').innerHTML = "Pasajeros adicional";
                    suma = parseFloat(acumulado) + parseFloat(dato1);
                    suma = suma.toFixed(2);
                    document.getElementById('monto').value = suma;
                    document.getElementById('view_monto').innerHTML = suma + "$";
                    break;

                    case '3':
                    document.getElementById('vs_hora_espera').style.display = 'block';
                    document.getElementById('variable3').value = dato;
                    document.getElementById('monto_v3').value = dato1;
                    document.getElementById('subtotal_v3').value = dato1;
                    document.getElementById('desc_variable3').innerHTML = "Hora de espera";
                    suma = parseFloat(acumulado) + parseFloat(dato1);
                    suma = suma.toFixed(2);
                    document.getElementById('monto').value = suma;
                    document.getElementById('view_monto').innerHTML = suma + "$";
                    break;

                    case '4':
                    document.getElementById('vs_aeropuerto').style.display = 'block';
                    document.getElementById('variable4').value = dato;
                    document.getElementById('monto_v4').value = dato1;
                    document.getElementById('subtotal_v4').value = dato1;
                    document.getElementById('desc_variable4').innerHTML = "Espera aeropuerto";
                    suma = parseFloat(acumulado) + parseFloat(dato1);
                    suma = suma.toFixed(2);
                    document.getElementById('monto').value = suma;
                    document.getElementById('view_monto').innerHTML = suma + "$";
                    break;

                    case '5':
                    document.getElementById('vs_silla').style.display = 'block';
                    document.getElementById('variable5').value = dato;
                    document.getElementById('monto_v5').value = dato1;
                    document.getElementById('subtotal_v5').value = dato1;
                    document.getElementById('desc_variable5').innerHTML = "Silla para Bebé";
                    suma = parseFloat(acumulado) + parseFloat(dato1);
                    suma = suma.toFixed(2);
                    document.getElementById('monto').value = suma;
                    document.getElementById('view_monto').innerHTML = suma + "$";
                    break;

                    case '6':
                    document.getElementById('vs_encomienda').style.display = 'block';
                    document.getElementById('variable6').value = dato;
                    document.getElementById('monto_v6').value = dato1;
                    document.getElementById('subtotal_v6').value = dato1;
                    document.getElementById('desc_variable6').innerHTML = "Encomienda";
                    suma = parseFloat(acumulado) + parseFloat(dato1);
                    suma = suma.toFixed(2);
                    document.getElementById('monto').value = suma;
                    document.getElementById('view_monto').innerHTML = suma + "$";
                    break;

                    case '7':
                    document.getElementById('vs_mascota').style.display = 'block';
                    document.getElementById('variable7').value = dato;
                    document.getElementById('monto_v7').value = dato1;
                    document.getElementById('subtotal_v7').value = dato1;
                    document.getElementById('desc_variable7').innerHTML = "Mascota";
                    suma = parseFloat(acumulado) + parseFloat(dato1);
                    suma = suma.toFixed(2);
                    document.getElementById('monto').value = suma;
                    document.getElementById('view_monto').innerHTML = suma + "$";
                    break;

            }
    }
}

function calcular() {  
    var tipo_vehiculo = document.getElementById('tipo-vehiculo-select').value;
    var tipo_ruta = document.getElementById('tipo-ruta-select').value;
    var traslado = document.getElementById('tipo-traslado-select').value;
    
    if ((tipo_vehiculo == '') && (tipo_ruta == '') && (traslado == '')) {
        alert("Debe seleccionar el tipo de vehículo, la ruta y translado para calcular el monto del servicio");
        document.getElementById('tipo-vehiculo-select').focus();
        return false;
    }




    var km = document.getElementById('km').value;

    var rango_banda_1 = document.getElementById('rango_banda_1').value;
    var banda_1 = document.getElementById('banda_1').value;

    var rango_banda_2 = document.getElementById('rango_banda_2').value;
    var banda_2 = document.getElementById('banda_2').value;

    var rango_banda_3 = document.getElementById('rango_banda_3').value;
    var banda_3 = document.getElementById('banda_3').value;

    var mas_20 = document.getElementById('mas_20').value;
    var nocturno = document.getElementById('nocturno').value;

    var km_particular = document.getElementById('km_particular').value;

    var horario = document.getElementById('item_horario').value;

    var tipo_vehiculo = document.getElementById('item_tipo_vehiculo').value;
    var ruta = document.getElementById('item_ruta').value;

    var porc_camioneta_interior = document.getElementById('porc_camioneta_interior').value;
    var porc_camioneta_caracas = document.getElementById('porc_camioneta_caracas').value;

    var valor_calculado = 0;
    var valor = 0
    var banda = 0
    var calculo_base = 0;
    var fuera_rango = 0;


    document.getElementById('monto_tarifario').style.display = 'block';
    //Generar los calculos
    if (km <= rango_banda_1) {
        banda = banda_1;
    }
    if (km <= rango_banda_2) {
        banda = banda_2;
    }
    if (km <= rango_banda_2) {
        banda = banda_2;
    }
    if (km >= 20) {
        banda = mas_20;
    }
    if ((km >= rango_3) && (km < 20)) {
        banda = km_particular;
    }

    calculo_base = km_particular * km;
    calculo_base = calculo_base.toFixed(2);


    if (horario == '1') { 
        horario = "Diurno";
        switch (tipo_vehiculo) {
            case "1": 
                tipo_vehiculo = "Sedan";  

                var rango_3 = document.getElementById('rango_banda_3').value;
                rango_3 = parseFloat(rango_3) + parseFloat(0.1);

                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (km >= 20) {
                    banda = mas_20*km;
                    
                }
                if ((km >= rango_3) && (km < 20)) {
                    banda = km_particular;
                    fuera_rango = 1;
                }

                if (fuera_rango == 1) {
                    valor = banda * km;
                    valor = valor.toFixed(2);
                    document.getElementById('item_km').value = valor;
                } else {
                    valor = banda ;
                    valor = parseFloat(valor).toFixed(2);
                    document.getElementById('item_km').value = banda;

                }
                break;
            case "2":
                tipo_vehiculo = "Camioneta";
                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == '2') {

                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = valor;
                break;
            case "5":
                tipo_vehiculo = "Van";
                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == '2') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = valor;

                break;
            case "3":
                tipo_vehiculo = "Autobus";
                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == '2') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = valor;

                break;

        }

        document.getElementById('monto').value = valor;
        document.getElementById('view_monto').innerHTML = valor + "$";
    } else {
        horario = "Nocturno";
        document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
        document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

        switch (tipo_vehiculo) {
            case "1":
                tipo_vehiculo = "Sedan";
                var fuera_rango = 0;
                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (km >= 20) {
                    banda = mas_20*km;
                   
                }
                if ((km >= rango_3) && (km < 20)) {
                    banda = km_particular;
                    fuera_rango = 1;
                }


                if (fuera_rango == 1) {
                    valor = banda * km + nocturno;
                    document.getElementById('item_km').value = valor;
                } else {

                    valor = parseFloat( banda ) + parseFloat(nocturno);
                    valor = valor.toFixed(2);
                    document.getElementById('item_km').value = valor;
                }

                break;
            case "2":
                tipo_vehiculo = "Camioneta";
                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == '2') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda) + parseFloat(nocturno);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base) + parseFloat(nocturno);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = valor;
                break;
            case "5":
                tipo_vehiculo = "Van";
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == '2') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda) + parseFloat(nocturno);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base) + parseFloat(nocturno);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = valor;

                break;
            case "3":
                tipo_vehiculo = "Autobus";
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == '2') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda) + parseFloat(nocturno);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base) + parseFloat(nocturno);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = valor;

                break;

        }
        document.getElementById('item_km').value = valor;

    }

    document.getElementById('monto').value = valor;
    document.getElementById('view_monto').innerHTML = valor + "$";

}

function mismo_cliente(){

    var nombre_cliente=document.getElementById('cliente-nombre_apellido').value;
    if (nombre_cliente==''){
        alert("No ha seleccionado el cliente");
    }else{
        var telef_cliente=document.getElementById('telefono_principal').value;

        document.getElementById('pasajero-nombre_apellido').value= nombre_cliente;
        document.getElementById('telefono_pax').value= telef_cliente;
    }   
  
}

function consolidado_servicio(){
    //SERVICIO

    if (document.getElementById('km').value==''){
        document.getElementById('ser').innerHTML='SIN DATOS DEL SERVICIO';
    }else{
        
    
        var ser="<table class='table'>";

        ser+="<tr style='background-color: #ededed;'><th>Km del Servicio</th>";
        ser+="<th style='background-color: #ededed;'>Descipción</th>";
        ser+="<th style='background-color: #ededed;'>Monto</th>";
        ser+="<th style='background-color: #ededed;'>Monto Total del Servicio</th></tr>";

        ser+="<tr><td>"+document.getElementById('km').value+"</td>";
        ser+="<td>"+document.getElementById('desc_km').value+"</td>";
        ser+="<td>$ "+document.getElementById('item_km').value+"</td>";
        ser+="<td>$ "+document.getElementById('monto').value+"</td></tr>";
        ser+="</table>";  

        document.getElementById('ser').innerHTML=ser;

        if ( (document.getElementById('monto_v1').value!='') || 
        (document.getElementById('monto_v1').value!=0)||

        (document.getElementById('monto_v2').value!='')||
        (document.getElementById('monto_v2').value!=0)||

        (document.getElementById('monto_v3').value!='')||
        (document.getElementById('monto_v4').value!='')||
        (document.getElementById('monto_v5').value!='')||
        (document.getElementById('monto_v6').value!='')||
        (document.getElementById('monto_v7').value!='')
        ){
            var ser_a="<table class='table'>";
            ser_a+="<tr style='background-color: #ededed;'><th>Servicio Adicional</th>";
            ser_a+="<th style='background-color: #ededed;'>Cantidad</th>";
            ser_a+="<th style='background-color: #ededed;'>Monto</th></tr>";
        

        if (document.getElementById('monto_v1').value!='' && document.getElementById('cant_v1').value!=0){
            ser_a+="<tr><td>"+document.getElementById('desc_variable1').innerHTML+"</td>";
            ser_a+="<td>"+document.getElementById('cant_v1').value+"</td>";
            cantidad= document.getElementById('cant_v1').value;
            var  monto_calculado=0;
            monto_calculado= document.getElementById('monto_v1').value*cantidad;
            ser_a+="<td>$ "+monto_calculado+"</td></tr>";
        }

        if (document.getElementById('monto_v2').value!='' && document.getElementById('cant_v2').value!=0){
            ser_a+="<tr><td>"+document.getElementById('desc_variable2').innerHTML+"</td>";
            ser_a+="<td>"+document.getElementById('cant_v2').value+"</td>";
            cantidad= document.getElementById('cant_v2').value;
            var  monto_calculado=0;
            monto_calculado= document.getElementById('monto_v2').value*cantidad;
            ser_a+="<td>$ "+monto_calculado+"</td></tr>";
        }
        if (document.getElementById('monto_v3').value!='' && document.getElementById('cant_v3').value!=0){
            ser_a+="<tr><td>"+document.getElementById('desc_variable3').innerHTML+"</td>";
            ser_a+="<td>"+document.getElementById('cant_v3').value+"</td>";
            cantidad= document.getElementById('cant_v3').value;
            var  monto_calculado=0;
            monto_calculado= document.getElementById('monto_v3').value*cantidad;
            ser_a+="<td>$ "+monto_calculado+"</td></tr>";
        }
        if (document.getElementById('monto_v4').value!='' && document.getElementById('cant_v4').value!=0 ){
            ser_a+="<tr><td>"+document.getElementById('desc_variable4').innerHTML+"</td>";
            ser_a+="<td>"+document.getElementById('cant_v4').value+"</td>";
            cantidad= document.getElementById('cant_v4').value;
            var  monto_calculado=0;
            monto_calculado= document.getElementById('monto_v4').value*cantidad;
            ser_a+="<td>$ "+monto_calculado+"</td></tr>";
        }
        if (document.getElementById('monto_v5').value!='' && document.getElementById('cant_v5').value!=0){
            ser_a+="<tr><td>"+document.getElementById('desc_variable5').innerHTML+"</td>";
            ser_a+="<td>"+document.getElementById('cant_v5').value+"</td>";
            cantidad= document.getElementById('cant_v5').value;
            var  monto_calculado=0;
            monto_calculado= document.getElementById('monto_v5').value*cantidad;
            ser_a+="<td>$ "+monto_calculado+"</td></tr>";
        }
        if (document.getElementById('monto_v6').value!='' && document.getElementById('cant_v6').value!=0){
            ser_a+="<tr><td>"+document.getElementById('desc_variable6').innerHTML+"</td>";
            ser_a+="<td>"+document.getElementById('cant_v6').value+"</td>";
            cantidad= document.getElementById('cant_v6').value;
            var  monto_calculado=0;
            monto_calculado= document.getElementById('monto_v6').value*cantidad;
            ser_a+="<td>$ "+monto_calculado+"</td></tr>";
    
        }
        if (document.getElementById('monto_v7').value!='' && document.getElementById('cant_v7').value!=0){
            ser_a+="<tr><td>"+document.getElementById('desc_variable7').innerHTML+"</td>";
            ser_a+="<td>"+document.getElementById('cant_v7').value+"</td>";
            cantidad= document.getElementById('cant_v7').value;
            var  monto_calculado=0;
            monto_calculado= document.getElementById('monto_v7').value*cantidad;
            ser_a+="<td>$ "+monto_calculado+"</td></tr>";
        }

        ser_a+="</table>";  
        document.getElementById('ser_a').innerHTML=ser_a;

            }
            else{
                document.getElementById('ser_a').innerHTML="SIN DATOS DEL SERVICIO ADICIONAL";
            }       
        
    }  

    //CLIENTE
    if (document.getElementById('cliente-nombre_apellido').value=='')
        document.getElementById('cli_nom').innerHTML='SIN DATOS DEL CLIENTE';
    else
        document.getElementById('cli_nom').innerHTML =document.getElementById('cliente-nombre_apellido').value+' ('+document.getElementById('telefono_principal').value+')';

    //PAX
    var num_pax=document.getElementById('num_pax').value;

    if ( (document.getElementById('pasajero-nombre_apellido').value=='') 
        &&  (document.getElementById('nombre1').value=='') )
    {
        document.getElementById('pax_nom').innerHTML='SIN DATOS DE O LOS PASAJEROS';
    }else
    { 
    
        var pax="<table class='table'>";
        pax+="<tr style='background-color: #ededed;'><th>Nombre y apellido</th>";
        pax+="<th style='background-color: #ededed;'>Teléfono</th>";
        pax+="<th style='background-color: #ededed;'>Fecha del Servicio</th>";
        pax+="<th style='background-color: #ededed;'>Hora del Servicio</th>";
        pax+="<th style='background-color: #ededed;'>Origen</th>";
        pax+="<th style='background-color: #ededed;'>Destino</th></tr>";

        if (document.getElementById('pasajero-nombre_apellido').value!=''){
    
            pax+="<tr><td>"+document.getElementById('pasajero-nombre_apellido').value+"</td>";
            pax+="<td>"+document.getElementById('telefono_pax').value+"</td>";
            pax+="<td>"+document.getElementById('pasajeroservicio-fecha').value+"</td>";
            pax+="<td>"+document.getElementById('w1').value+"</td>";
            pax+="<td>"+document.getElementById('pasajeroservicio-origen').value+"</td>";
            pax+="<td>"+document.getElementById('pasajeroservicio-destino').value+"</td></tr>";
        }
        
        
        if (num_pax!=''){ 
            for (let index = 1; index <= parseInt(num_pax)-1; index++) {
                pax+="<tr><td>"+document.getElementById('nombre'+index).value+"</td>"; 
                pax+="<td>"+document.getElementById('telefono'+index).value+"</td>"; 
                pax+="<td>"+document.getElementById('fecha'+index).value+"</td>"; 
                pax+="<td>"+document.getElementById('hora'+index).value+"</td>"; 
                pax+="<td>"+document.getElementById('origen'+index).value+"</td>"; 
                pax+="<td>"+document.getElementById('destino'+index).value+"</td></tr>"; 
            }
        
        }
        pax+="</table>";     
    
        document.getElementById('pax_nom').innerHTML=pax;
    }
}

function add_categoria(dato, tipo) {  

    switch (tipo) {
        case 'tipo_vehiculo':
            document.getElementById('item_tipo_vehiculo').value = dato;
            break;
        case 'ruta':
            document.getElementById('item_ruta').value = dato;
            break;
        case 'horario':
            document.getElementById('item_horario').value = dato;
            break;
    }


    switch (dato) {
        case 'Autobus': 
            document.getElementById('autobus').class="imagen-check";
            break;
    }

    var km = document.getElementById('km').value;

    if ((km != '') || (km != 0)) {
        calcular();
    } else {
        alert("Debe ingresar la cantidad de Km del Servicio para general el calculo");
        document.getElementById('km').focus();

    }

}

function calcular_p() {
    var km = document.getElementById('km').value;

    var banda_1 =0;

    var banda_2 = 0;

    var banda_3 = 0;

    var mas_20 = 0;
    var nocturno = 0;

    var km_particular = document.getElementById('km_particular').value;

    var horario = document.getElementById('item_horario').value;

    var tipo_vehiculo = document.getElementById('item_tipo_vehiculo').value;
    var ruta = document.getElementById('item_ruta').value;

    var porc_camioneta_interior = document.getElementById('porc_camioneta_interior').value;
    var porc_camioneta_caracas = document.getElementById('porc_camioneta_caracas').value;

    var valor_calculado = 0;
    var valor = 0
    var banda = 0
    var calculo_base = 0;
    var fuera_rango = 0;


    document.getElementById('monto_tarifario').style.display = 'block';
    //Generar los calculos
    if (km <= rango_banda_1) {
        banda = banda_1;
    }
    if (km <= rango_banda_2) {
        banda = banda_2;
    }
    if (km <= rango_banda_2) {
        banda = banda_2;
    }
    if (km >= 20) {
        banda = mas_20;
    }
    if ((km >= rango_3) && (km < 20)) {
        banda = km_particular;
    }

    calculo_base = km_particular * km;
    calculo_base = calculo_base.toFixed(2);


    if (horario == 'Diurno') {

        switch (tipo_vehiculo) {
            case 'Sedán':

                var rango_3 = document.getElementById('rango_banda_3').value;
                rango_3 = parseFloat(rango_3) + parseFloat(0.1);

                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (km >= 20) {
                    banda = mas_20*km;
                    
                }
                if ((km >= rango_3) && (km < 20)) {
                    banda = km_particular;
                    fuera_rango = 1;
                }

                if (fuera_rango == 1) {
                    valor = banda * km;
                    valor = valor.toFixed(2);
                    document.getElementById('item_km').value = valor;
                } else {
                    valor = banda ;
                    valor = parseFloat(valor).toFixed(2);
                    document.getElementById('item_km').value = banda;

                }
                break;
            case 'Camioneta':
                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == 'Gran Caracas') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base);
                    valor = valor.toFixed(2);
                }

                valor=0;
                document.getElementById('item_km').value = 0;
                break;
            case 'Van':
                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == 'Gran Caracas') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = 0;

                break;
            case 'Autobus':
                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == 'Gran Caracas') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = 0;

                break;

        }

        document.getElementById('monto').value = valor;
        document.getElementById('view_monto').innerHTML = valor + "$";
    } else {
        document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
        document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

        switch (tipo_vehiculo) {
            case 'Sedán':
             
                var fuera_rango = 0;
                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (km >= 20) {
                    banda = mas_20*km;
                   
                }
                if ((km >= rango_3) && (km < 20)) {
                    banda = km_particular;
                    fuera_rango = 1;
                }


                if (fuera_rango == 1) {
                    valor = banda * km + nocturno;
                    document.getElementById('item_km').value = 0;
                } else {

                    valor = parseFloat( banda ) + parseFloat(nocturno);
                    valor = valor.toFixed(2);
                    document.getElementById('item_km').value = 0;
                }

                break;
            case 'Camioneta':
                document.getElementById('desc_km').value = tipo_vehiculo + "/" + horario;
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == 'Gran Caracas') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda) + parseFloat(nocturno);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base) + parseFloat(nocturno);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = 0;
                break;
            case 'Van':
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == 'Gran Caracas') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda) + parseFloat(nocturno);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base) + parseFloat(nocturno);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = 0;

                break;
            case 'Autobus':
                document.getElementById('descrip_km_item_view').innerHTML = tipo_vehiculo + "/" + horario;

                if (ruta == 'Gran Caracas') {
                    valor = parseFloat(banda) * parseFloat(porc_camioneta_caracas) / 100 + parseFloat(banda) + parseFloat(nocturno);
                    if (valor < 35) {
                        valor = parseFloat(35) + parseFloat(nocturno);
                    }
                } else {
                    valor = parseFloat(calculo_base) * parseFloat(porc_camioneta_interior) / 100 + parseFloat(calculo_base) + parseFloat(nocturno);
                    valor = valor.toFixed(2);
                }
                document.getElementById('item_km').value = 0;

                break;

        }
        document.getElementById('item_km').value = 0;

    }

    document.getElementById('monto').value = 0;
    document.getElementById('view_monto').innerHTML = 0 + "$";

}

function cambia_monto(valor){

    monto=document.getElementById('monto').value;

    document.getElementById('monto').value = parseFloat(valor) + parseFloat(monto);
    document.getElementById('view_monto').innerHTML = valor + "$";
}

function add_categoria_p(dato, tipo) {

    switch (tipo) {
        case 'tipo_vehiculo':
            document.getElementById('item_tipo_vehiculo').value = dato;
            break;
        case 'ruta':
            document.getElementById('item_ruta').value = dato;
            break;
        case 'horario':
            document.getElementById('item_horario').value = dato;
            break;
    }


    switch (dato) {
        case 'Autobus': 
            document.getElementById('autobus').class="imagen-check";
            break;
    }

    var km = document.getElementById('km').value;

    if ((km != '') || (km != 0)) {
        calcular_p();
    } else {
        alert("Debe ingresar la cantidad de Km del Servicio para general el calculo");
        document.getElementById('km').focus();

    }

}

function suma_precio(monto,campo){

    //Cambio el valor
    document.getElementById('monto').value -= document.getElementById(campo).value;
    monto_valor= document.getElementById('monto').value;
    monto_nuevo= parseFloat(monto_valor)+ parseFloat(monto);
    document.getElementById('view_monto').innerHTML = monto_nuevo + "$";
    document.getElementById('monto').value=monto_nuevo;
    document.getElementById(campo).value=monto;
}

function suma_cantidad_p(dato){
    var cantidad= document.getElementById('cant_v'+dato).value;
    var monto= document.getElementById('monto_v'+dato).value;
    var subtotal= document.getElementById('subtotal_v'+dato).value;

    var acumulado=document.getElementById('monto').value;

    var valor= 0;
    var valor_suma= 0;

    valor= parseFloat(monto)*parseFloat(cantidad);
    valor = valor.toFixed(2);
    valor_suma= parseFloat(valor)-parseFloat(subtotal); 
    document.getElementById('subtotal_v'+dato).value= valor;
    valor=parseFloat(acumulado)+ parseFloat(valor_suma);
    valor = valor.toFixed(2);
    document.getElementById('monto').value=parseFloat(valor);
    document.getElementById('view_monto').innerHTML = valor + "$";
}
function suma_monto_factura(monto,id){

    var suma=document.getElementById('monto_facturado').value; 
    document.getElementById('item_seleccionados').value += id +','; 
    var valor= parseFloat(suma)+parseFloat(monto);
    valor = valor.toFixed(2);

    document.getElementById('monto_facturado').value=valor;
    
    //VALORES A CALCULAR
    var bs_valor= valor*document.getElementById('tasa').value;
    var iva=bs_valor*0.16;
    document.getElementById('monto_bs').value= bs_valor;

    bs_valor = bs_valor.toFixed(2);
    iva = iva.toFixed(2);
    document.getElementById('iva').value= iva;

    document.getElementById('view_monto').style.display = 'block';
    document.getElementById('view_monto').innerHTML = "Monto del IVA 16% " +formatoNumerico(iva) + " Bs." + "<br> Monto total de la factura " + formatoNumerico(bs_valor) + " Bs.";
 }

 function recalcular_factura(){
    var suma=document.getElementById('monto_facturado').value; 
    var bs_valor= suma*document.getElementById('tasa').value;

    //VALORES A CALCULAR
    var iva=bs_valor*0.16;

    bs_valor = bs_valor.toFixed(2);
    document.getElementById('monto_bs').value= bs_valor;
    iva = iva.toFixed(2);
    document.getElementById('iva').value= iva;
    document.getElementById('view_monto').style.display = 'block';
    document.getElementById('view_monto').innerHTML = "Monto del IVA 16% " +formatoNumerico(iva) + " Bs." + "<br> Monto total de la factura " + formatoNumerico(bs_valor) + " Bs.";
 }

 const formatoNumerico = (number) => {
    const exp = /(\d)(?=(\d{3})+(?!\d))/g;
    const rep = '$1.';
    let arr = number.toString().split('.');
    arr[0] = arr[0].replace(exp,rep);
    return arr[1] ? arr.join(','): arr[0];
  }

function quitar_p(dato){
    var subtotal=document.getElementById('subtotal_v'+dato).value;
    var monto=document.getElementById('monto').value;
    var view_monto=document.getElementById('view_monto').value;

    // Resto el monto
    monto= parseFloat(monto)-parseFloat(subtotal);
    monto = monto.toFixed(2);
    document.getElementById('monto').value=monto;
    document.getElementById('view_monto').innerHTML = monto + "$";
    document.getElementById('subtotal_v'+dato).value=0;

    switch (dato) {
        case 1:
            document.getElementById('vs_maleta').style.display = 'none';
            break;
        case 2:
            document.getElementById('vs_pax').style.display = 'none';
            break;
        case 3:
            document.getElementById('vs_hora_espera').style.display = 'none';
            break;
        case 4:
            document.getElementById('vs_aeropuerto').style.display = 'none';
            break;
        case 5:
            document.getElementById('vs_silla').style.display = 'none';
            break;
        case 6:
            document.getElementById('vs_encomienda').style.display = 'none';
            break;
        case 7:
            document.getElementById('vs_mascota').style.display = 'none';
            break;
    }

    //Limpiamos la variable


}

