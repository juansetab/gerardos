function addMascota() {
    m_caso = document.querySelector("#form_mascota #m_caso").value;
    m_nombre = document.querySelector("#form_mascota #m_nombre").value;
    m_nombre_id = Date.now();
    m_especie = document.querySelector("#form_mascota #m_especie").value;
    m_raza = document.querySelector("#form_mascota #m_raza").value;
    m_edad = document.querySelector("#form_mascota #m_edad").value;
    m_sexo = document.querySelector("#form_mascota #m_sexo").value;
    m_tipo_muestra = document.querySelector("#form_mascota #m_tipo_muestra").value;
    m_muestreo = document.querySelector("#form_mascota #m_muestreo").value;
    m_anamnesis = document.querySelector("#form_mascota #m_anamnesis").value;
    m_observaciones = document.querySelector("#form_mascota #m_observaciones").value;
    if (mascotasArray.indexOf(m_nombre_id) !== -1) {
        s_SwalFire("error", "¡Error!", "Paciente ya existe", "red");
        return false;
    }
    var casoRGEX = /^[0-9]{2}[-]{0,1}[0-9]{4}$/;
    if (!casoRGEX.test(m_caso)) {
        s_SwalFire("error", "¡Error!", "Formato de número de caso erróneo", "red");
        return false;
    }
    inputs = ["m_caso", "m_nombre", "m_especie", "m_raza", "m_edad", "m_sexo", "m_tipo_muestra", "m_muestreo", "m_anamnesis"];
    nombres = ["No. de caso", "Nombre", "Especie", "Raza", "Edad", "Sexo", "Tipo de muestra", "Muestreo", "Anamnesis"];
    for (i = 0; i < inputs.length; i++) {
        if (document.querySelector(`#form_mascota #${inputs[i]}`).value == "") {
            s_SwalFire("error", "¡Error!", "Falta llenar campo '" + nombres[i] + "'", "red");
            return false;
        }
    }
    html = `<div id="accordionItem${m_nombre_id}" class="card accordion-item" data-nombre="${m_nombre}">
            <h2 class="accordion-header" id="headingOne">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion${m_nombre_id}"" aria-expanded="false" aria-controls="accordion${m_nombre_id}">
                    Paciente "${m_nombre}"
                </button>
            </h2>
            <div id="accordion${m_nombre_id}" class="accordion-collapse collapse" data-bs-parent="#mascotasAccordion" style="">
                <div class="accordion-body">
                    <div class="row">
                        <div class='form-group col-md-4 col-sm-12 col-lg-4'>
                            <label class='form-label' for='m_caso'>No. de caso: </label>
                            <input type='text' class='form-control form-control-sm' id='m_caso' name='m_caso' placeholder='' value="${m_caso}" required />
                        </div>
                        <div class='form-group col-md-4 col-sm-12 col-lg-4'>
                                <label class='form-label' for='nombre'>Nombre: </label>
                                <input type='text' class='form-control form-control-sm' id='m_nombre' name='m_nombre' placeholder='' value="${m_nombre}" required />
                            </div>
                            <div class='form-group col-md-4 col-sm-12 col-lg-4'>
                                <label class='form-label' for='especie'>Especie: </label>
                                <input type='text' class='form-control form-control-sm' id='m_especie' name='m_especie' placeholder='' value="${m_especie}" required />
                            </div>
                            <div class='form-group col-md-4 col-sm-12 col-lg-4'>
                                <label class='form-label' for='raza'>Raza: </label>
                                <input type='text' class='form-control form-control-sm' id='m_raza' name='m_raza' placeholder='' value="${m_raza}" required />
                            </div>
                            <div class='form-group col-md-4 col-sm-12 col-lg-4'>
                                <label class='form-label' for='edad'>Edad: </label>
                                <input type='number' class='form-control form-control-sm' id='m_edad' name='m_edad' placeholder='' value="${m_edad}" required />
                            </div>
                            <div class='form-group col-md-4 col-sm-12 col-lg-4'>
                                <label class='form-label' for='sexo'>Género: </label>
                                <select class='form-control form-control-sm' id='m_sexo' name='m_sexo'>
                                    <option value='MACHO'>MACHO</option>
                                    <option value='HEMBRA'>HEMBRA</option>
                                    <option value='MACHO ENTERO'>MACHO ENTERO</option>
                                    <option value='MACHO ESTERILIZADO'>MACHO ESTERILIZADO</option>
                                    <option value='HEMBRA ENTERA'>HEMBRA ENTERA</option>
                                    <option value='HEMBRA ESTERILIZADA'>HEMBRA ESTERILIZADA</option>
                                    <option value='N/R'>N/R</option>
                                </select>
                            </div>
                            <div class='form-group col-md-4 col-sm-12 col-lg-4'>
                                <label class='form-label' for='edad'>Fecha de muestreo: </label>
                                <input type='date' class='form-control form-control-sm' id='m_muestreo' name='m_muestreo' placeholder='' value="${m_muestreo}" required />
                            </div>
                            <div class='form-group col-md-4 col-sm-12 col-lg-4'>
                                <label class='form-label' for='nombre'>Tipo de muestra: </label>
                                <input type='text' class='form-control form-control-sm' id='m_tipo_muestra' name='m_tipo_muestra' placeholder='' value="${m_tipo_muestra}" required />
                            </div>
                            <div class='form-group col-md-6 col-sm-6 col-lg-6'>
                                <label class='form-label' for='edad'>Anamnesis: </label>
                                <textarea class='form-control form-control-sm' id='m_anamnesis' name='m_anamnesis' rows='3' required>${m_anamnesis}</textarea>
                            </div>
                            <div class='form-group col-md-6 col-sm-6 col-lg-6'>
                                <label class='form-label' for='edad'>Observaciones: </label>
                                <textarea class='form-control form-control-sm' id='m_observaciones' name='m_observaciones' rows='3' required>${m_observaciones}</textarea>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-sm btn-danger" onclick="deleteMascota('${m_nombre_id}')">Eliminar paciente</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    document.querySelector("#mascotasAccordion").insertAdjacentHTML('beforeend', html);
    document.querySelector(`#accordionItem${m_nombre_id} #m_sexo`).value = m_sexo;
    mascotasArray.push(m_nombre_id);
    document.querySelector("#form_mascota").reset();
    IMask(
        document.querySelector(`#accordionItem${m_nombre_id} #m_caso`), {
            mask: '00-0000'
        }
    )
    max++;
    document.querySelector(`#form_mascota #m_caso`).value = year + "-" + max.toString().padStart(4, '0');
    console.log(mascotasArray);
    s_SwalFire("success", "Añadido!", "Añadido paciente");
}

function deleteMascota(nombre) {
    mascota = document.querySelector(`#accordion${nombre} #m_nombre`).value;
    Swal.fire({
        title: `¿Está seguro de eliminar al paciente "${mascota}"?`,
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        cancelButtonText: `No eliminar`
    }).then((result) => {
        if (result.isConfirmed) {
            document.querySelector(`#accordionItem${nombre}`).remove();
            mascotasArray.splice(mascotasArray.indexOf(parseInt(nombre)), 1);
            s_SwalFire("success", "¡Hecho!", "Se eliminó el paciente");
            console.log(mascotasArray);
            /**
             * AQUI FALTA EL CÓDIDO PARA ELIMINAR / VALIDAD / DEJAR EN BLANCO ALGÚN SELECT QUE TENGA A LA MASCOTA ELIMINADA
             */
        } else if (result.isDenied) {
            s_SwalFire("info", "¡Sin cambios!", "No se eliminó ningún elemento");
        }
    });
}

function cargaClientes(data) {
    options = `<option value='0' selected>Nuevo cliente</option>`;
    data.forEach(function(value, index) {
        options += `<option value="${value.id}">${value.nombres} ${value.primer_apellido} ${value.segundo_apellido}</option>`;
        document.querySelector("#c_clientes").innerHTML = options;
    }, this);
}

function cargaClienteId(data) {
    document.querySelector("#primer_apellido").value = data.primer_apellido;
    document.querySelector("#segundo_apellido").value = data.segundo_apellido;
    document.querySelector("#nombres").value = data.nombres;
    document.querySelector("#clinica").value = data.clinica;
    document.querySelector("#telefono").value = data.telefono;
    document.querySelector("#correo").value = data.correo;
}

function calculaCajaBanco(element) { //Posible obsoleto al meter créditos
    value = element.value;
    subtraction = (parseFloat(TOTAL) - parseFloat(value)).toFixed(2);
    if(element.getAttribute("id") == "cantidad_caja"){
        document.querySelector("#cantidad_banco").value = subtraction;
    }else{
        document.querySelector("#cantidad_caja").value = subtraction;
    }
}

function calculaCajaBancoCredito() {
    caja = document.querySelector("#cantidad_banco").value;
    banco = document.querySelector("#cantidad_caja").value;
    subtotal = (parseFloat(caja) + parseFloat(banco));
    credito = (parseFloat(TOTAL) - parseFloat(subtotal)).toFixed(2);
    document.querySelector("#cantidad_credito").value = credito;
}

function cargaAnalisis() {
    if (mascotasArray.length == 0) {
        s_SwalFire("error", "¡Error!", "No se ha registrado ningún paciente");
        return false;
    }
    exists = false;
    select = document.querySelector("#id_caso");
    option = select.options[select.selectedIndex];
    table_tr = document.querySelectorAll("#analisisTable tbody tr");
    table_tr.forEach(function(tr, index) {
        if (tr.dataset.id == option.value) {
            exists = true;
        }
    });
    html_mascotas = "";
    if (option.dataset.tipoconcepto == "P") {
        mascotasArray.forEach(function(value) {
            valor = document.querySelector(`#accordion${value} #m_nombre`).value;
            console.log(valor);
            html_mascotas += `<option value="${value}">${valor}</option>`;
        });
    } else {
        html_mascotas = `<option value="todas" selected>Todas</option>`;
    }

    precio = `$ ${option.dataset.precio}`;
    tr = `<tr data-id='${option.value}' data-precio='${option.dataset.precio}' data-clave='${option.dataset.clave}' data-descripcion='${option.dataset.descripcion}' data-tipoconcepto='${option.dataset.tipoconcepto}' data-porcentaje='${option.dataset.porcentaje}'  data-tipodescuento='${option.dataset.tipodescuento}'>
        <td class='text-center'>
            <div class='btn-group btn-group-sm' role='group'>
                <button type="button" class="btn btn-danger btn-sm" onclick="s_DeleteHTMLRow(this, calculaTotal)">Eliminar</button>
            </div>  
        </td>
        <td><select class='form-control form-control-sm' id='mascota'>${html_mascotas}</select></td>
        <td id="clave">${option.dataset.clave}</td>
        <td id="descripcion">${option.dataset.descripcion}</td>
        <td id="pu" class="text-end">` + (option.dataset.tipoconcepto == "P" ? s_CurrencyFormat(option.dataset.precio) : cantidadDescuento(option)) + `</td>
        <td id="cantidad" style="text-center" class="text-center"><input type="number" step="1" value="1" ` + (option.dataset.tipoconcepto == "P" ? "" : "readonly") + ` onchange="calculaTotal()"></td>
        <td id="precio" class="text-end">` + s_CurrencyFormat(option.dataset.precio) + `</td>
        </tr>`;
    document.querySelector("#analisisTable tbody").insertAdjacentHTML('beforeend', tr);
    calculaTotal();
}

function calculaTotal() {
    var table = document.querySelector("#analisisTable tbody");
    precio = 0;
    descuentos = [];
    descuento = 0;
    iva = 0;
    for (var i = 0, row; row = table.rows[i]; i++) {
        if (table.rows[i].dataset.tipoconcepto == "P") {
            subprecio = parseFloat(table.rows[i].dataset.precio) * parseFloat(table.rows[i].querySelector("#cantidad input").value);
            precio += parseFloat(subprecio);
            table.rows[i].querySelector("#precio").innerHTML = s_CurrencyFormat(subprecio);
        } else {
            descuentos.push(table.rows[i]);
        }
    }
    for (var i = 0; i < descuentos.length; i++) {
        if (descuentos[i].dataset.tipodescuento == "P") { //Si es porcentaje
            descuento += (precio / 100) * parseFloat(descuentos[i].dataset.porcentaje);
            descuentos[i].querySelector("#precio").innerHTML = "- " + s_CurrencyFormat((precio / 100) * parseFloat(descuentos[i].dataset.porcentaje));
            descuentos[i].dataset.precio = (precio / 100) * parseFloat(descuentos[i].dataset.porcentaje);

        } else {
            descuento += parseFloat(descuentos[i].dataset.precio);
        }
    }
    if (document.querySelector("#checkIVA").checked == true) {
        iva = ((precio - descuento) / 100) * 16;
    }
    TOTAL = precio - descuento + iva;
    document.querySelector(`#subtotal b`).innerHTML = s_CurrencyFormat(precio);
    document.querySelector(`#descuento b`).innerHTML = s_CurrencyFormat(descuento);
    document.querySelector(`#iva b`).innerHTML = s_CurrencyFormat(iva);
    document.querySelector(`#total b`).innerHTML = s_CurrencyFormat(TOTAL);
    document.querySelector("#cantidad_caja").value = TOTAL;
    document.querySelector("#cantidad_banco").value = "0.00";

}

function cantidadDescuento(option) {
    if (option.dataset.tipodescuento == "P") {
        html = "- " + option.dataset.porcentaje + " %";
    } else {
        html = "- " + s_CurrencyFormat(option.dataset.precio)
    }
    return html;
}

function validateData() {
    if (mascotasArray.length == 0) {
        s_SwalFire("error", "¡Error!", "No se ha registrado ningún paciente");
        return false;
    }
    for (i = 0; i < mascotasArray.length; i++) {
        m_nombre_id = mascotasArray[i];
        inputs = ["m_caso", "m_especie", "m_raza", "m_edad", "m_sexo", "m_tipo_muestra", "m_muestreo", "m_anamnesis"];
        nombres = ["No. de caso", "Especie", "Raza", "Edad", "Sexo", "Tipo de muestra", "Muestreo", "Anamnesis"];
        for (j = 0; j < inputs.length; j++) {
            if (document.querySelector(`#accordionItem${m_nombre_id} #${inputs[j]}`).value == "") {
                s_SwalFire("error", "¡Error!", "Falta llenar campo '" + nombres[j] + "' del paciente '" + m_nombre_id + "'", "red");
                return false;
            }
        }
    }
    rows = document.querySelectorAll(`#analisisTable tbody tr`);
    if (rows.length == 0) {
        s_SwalFire("error", "¡Error!", `No se ha añadido ningun análisis`);
        return false;
    }
    error = false;
    rows.forEach(function(tr, index) {
        mascota = tr.querySelector(`#mascota`).value;
        if (mascota != "todas") {
            console.log(mascota);
            if (mascotasArray.indexOf(parseInt(mascota)) === -1)
                error = true;
        }
    });
    if (error == true) {
        s_SwalFire("error", "¡Error!", `Paciente seleccionado en análisis no se encuentra en la lista de pacientes`, "red");
        return false;
    }
    Swal.fire({
        title: "Espere un momento por favor...",
        html: "El sistema está guardando toda la información en la base de datos",
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
            submitData();
        },
    });

}