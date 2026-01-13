var fila_seleccionada = null;
var datos = null;
var array_promociones = [];

let eliminados = [];
$(document).ready(function () {
    valida();
    enumerar($("#lista_productos"));
    enumerar($("#lista_detalle"));

    $("#cliente").change(valida);
    // $('#cliente').keyup(valida);

    $("#CancelarAgregar").click(limpiar);

    $(document).on(
        "click",
        "#lista_productos .fila .btns-opciones a.agregar",
        function (e) {
            e.preventDefault();
            $("#url_info").val($(this).parents("tr.fila").attr("data-url"));
            $("#data_cod").val($(this).parents("tr.fila").attr("data-cod"));
            fila_seleccionada = $(this).parents("tr.fila");
            $("#stock_disponible").val(
                $(this).parents("tr.fila").children("td").eq(3).text()
            );
            $("#nombre_producto").text(
                $(this).parents("tr.fila").children("td").eq(1).text()
            );
            $("#modal-agregar").modal("show");
        }
    );

    // CALCULAR DESCUENTOS
    $("#lista_detalle").on("change", ".fila .select select", function (e) {
        let fila = $(this).parents("tr");
        let costo = parseFloat(fila.children("td").eq(2).text());
        let cantidad = parseInt(fila.children("td").eq(3).text());
        let total = costo * cantidad;

        $.ajax({
            type: "GET",
            url: $("#urlObtieneDescuento").val(),
            data: { id: $(this).val() },
            dataType: "json",
            success: function (descuento) {
                let valor_descuento = descuento.descuento;
                let tipo_descuento = descuento.tipo;
                if (tipo_descuento == "BS") {
                    // Descuento por Bs.
                    total =
                        (parseFloat(costo) - parseFloat(valor_descuento)) *
                        cantidad; //DESCUENTO BS AL C.U
                } else {
                    // Descuento por %
                    total = costo - costo * (parseFloat(valor_descuento) / 100); //DESCUENTO POR PORCENTAJE SUB TOTAL
                    total = total * cantidad;
                }

                fila.children("td").eq(5).text(total.toFixed(2));
                sumaTotal();
            },
        });
    });

    // AGREGAR PRODUCTO
    $("#btnAgregarProducto").click(function () {
        let self = $(this);
        self.prop("disabled", true);
        if ($("#cantidad_productos").val() != "") {
            $("#error-cantidad").addClass("oculto");
            if (
                parseInt($("#cantidad_productos").val()) <=
                parseInt($("#stock_disponible").val())
            ) {
                $("#error-stock").addClass("oculto");
                $.ajax({
                    type: "GET",
                    url: $("#url_info").val(),
                    data: { cantidad: $("#cantidad_productos").val() },
                    dataType: "JSON",
                    success: function (response) {
                        let select_descuentos = $(
                            `${response.select_descuentos}`
                        );
                        // AGREGAR UNA FILA DE PRODUCTO CON LOS DATOS
                        let total = (
                            parseFloat(response.costo) *
                            parseInt($("#cantidad_productos").val())
                        ).toFixed(2);

                        $.ajax({
                            type: "GET",
                            url: $("#urlObtieneDescuento").val(),
                            data: { id: select_descuentos.val() },
                            dataType: "json",
                            success: function (descuento) {
                                let valor_descuento = descuento.descuento;
                                let tipo_descuento = descuento.tipo;

                                if (tipo_descuento == "BS") {
                                    // Descuento por Bs.
                                    total = (
                                        (parseFloat(response.costo) -
                                            parseFloat(valor_descuento)) *
                                        parseInt($("#cantidad_productos").val())
                                    ).toFixed(2); //DESCUENTO BS AL C.U
                                } else {
                                    // Descuento por %
                                    total =
                                        parseFloat(response.costo) -
                                        parseFloat(response.costo) *
                                            (parseFloat(valor_descuento) / 100); //DESCUENTO POR PORCENTAJE SUB TOTAL
                                    total = (
                                        total *
                                        parseInt($("#cantidad_productos").val())
                                    ).toFixed(2);
                                }

                                let fila = `<tr data-cod="${$(
                                    "#data_cod"
                                ).val()}" data-nombre="${
                                    response.nombre
                                }" data-cost="${response.costo}" class="fila">
                                                <td>#</td>
                                                <td>${response.nombre}</td>
                                                <td class="centreado">${
                                                    response.costo
                                                }</td>
                                                <td class="centreado">${$(
                                                    "#cantidad_productos"
                                                ).val()}</td>
                                                <td class="centreado select" data-id="${select_descuentos.val()}">${
                                    response.select_descuentos
                                }</td>
                                                <td class="centreado">${total}</td>
                                                <td class="centreado quitar"><span title="Quitar" class="eliminar"><i class="fa fa-times"></i></span></td>
                                            </tr>`;
                                $("#lista_detalle")
                                    .children("tr.total")
                                    .before(fila);
                                // si agrega actualizar el stock
                                fila_seleccionada
                                    .children("td")
                                    .eq(3)
                                    .text(
                                        parseInt($("#stock_disponible").val()) -
                                            parseInt(
                                                $("#cantidad_productos").val()
                                            )
                                    );

                                if (
                                    response.promocion_id != "" &&
                                    response.promocion_id != null
                                ) {
                                    // si devuelve algo en la variable promocion_id
                                    // guardarlo en el array_promociones
                                    array_promociones.push(
                                        response.promocion_id
                                    );
                                }
                                // console.log(array_promociones);
                                enumerar($("#lista_detalle"), "prestamos");
                                sumaTotal();
                                $("#modal-agregar").modal("hide");
                                limpiar();
                                valida();
                                self.removeAttr("disabled");
                            },
                        });
                    },
                });
            } else {
                self.removeAttr("disabled");
                $("#error-stock").removeClass("oculto");
            }
        } else {
            self.removeAttr("disabled");
            $("#error-cantidad").removeClass("oculto");
        }
    });

    // QUITAR PRODUCTO DE LA LISTA
    $("#lista_detalle").on("click", "tr.fila td.quitar span", function () {
        let data_cod = $(this).parents("tr").attr("data-cod");
        let cantidad = $(this).parents("tr").children("td").eq(3).text();
        console.log(data_cod);
        // actualizar la cantidad de la lista de productos
        let fila_video = $("#lista_productos").children(
            'tr[data-cod="' + data_cod + '"]'
        );
        let cantidad_actual = fila_video.children("td").eq(3).text();
        fila_video
            .children("td")
            .eq(3)
            .text(parseInt(cantidad_actual) + parseInt(cantidad));
        // eliminar la fila
        $(this).parents("tr").remove();
        enumerar($("#lista_detalle"), "prestamos");
        sumaTotal();
        valida();
        if ($(this).parents(".fila").hasClass("existe")) {
            eliminados.push($(this).parents("tr.existe").attr("data-id"));
        }
    });

    $("#fecha_devolucion").change(validaFecha);

    $("#registrarVenta").click(function (e) {
        e.preventDefault();
        registraVenta();
    });
});

function registraVenta() {
    datos = {
        productos: [],
        precios: [],
        descuentos: [],
        cantidades: [],
        totales: [],
        cantidad_total: "",
        total: "",
        total_final: "",
        cliente_id: "",
        fecha_venta: "",
        promociones: [],
    };

    // ARMAR CODIGOS,PRECIOS,CANTIDADES Y TOTALES
    let filas = $("#lista_detalle").children("tr.fila");
    let array_productos = [];
    let array_precios = [];
    let array_cantidades = [];
    let array_totales = [];
    let array_descuentos = [];
    // ARMA EL DETALLE DE VENTA
    filas.each(function () {
        if (!$(this).hasClass("existe")) {
            let codigo = $(this).attr("data-cod");
            let precio = $(this).children("td").eq(2).text();
            let cantidad = $(this).children("td").eq(3).text();
            let descuento = $(this)
                .children("td")
                .eq(4)
                .children("select")
                .val();
            let total = $(this).children("td").eq(5).text();
            array_productos.push(codigo);
            array_precios.push(precio);
            array_descuentos.push(descuento);
            array_cantidades.push(cantidad);
            array_totales.push(total);
        }
    });

    // OBTENER LOS DATOS DESCUENTO, TOTAL FINAL Y FECHAS ARMANDO EL OBJETO DATOS
    let fila_total = $("#lista_detalle").children("tr.total");
    let td_cantidad = fila_total.children("td").eq(1);
    let td_total = fila_total.children("td").eq(3);

    datos.productos = array_productos;
    datos.precios = array_precios;
    datos.descuentos = array_descuentos;
    datos.cantidades = array_cantidades;
    datos.totales = array_totales;
    datos.cantidad_total = td_cantidad.text();
    datos.total = td_total.text();
    datos.total_final = $("#total_final").val();
    datos.cliente_id = $("#cliente").val();
    datos.fecha_venta = $("#fecha_venta").val();
    datos.promociones = array_promociones;

    //AGREGAR LOS ELIMINADOS SI EXISTEN
    if (eliminados.length > 0) {
        datos.eliminados = eliminados;
    }
    console.log(datos);
    $.ajax({
        headers: { "X-CSRF-TOKEN": $("#token").val() },
        type: "POST",
        url: $("#urlRegistraVenta").val(),
        data: datos,
        dataType: "json",
        success: function (response) {
            if (response.msj) {
                window.location = response.ruta;
            } else {
                $(".error_venta").removeClass("oculto");
                $("#message_error").text(response.message);
            }
        },
        error: function (e) {
            $(".error_venta").removeClass("oculto");
            console.log(e.responseJSON.message);
            $("#message_error").text(e.responseJSON.message);
        },
    });
}

function valida() {
    $("#registrarVenta").prop("disabled", true);
    let filas_prestamo = $("#lista_detalle").children("tr.fila");
    if (
        $("#cliente").val() != "" &&
        $("#cliente").val() != null &&
        filas_prestamo.length > 0
    ) {
        $("#registrarVenta").prop("disabled", false);
    }
}

function validaFecha() {
    $.ajax({
        type: "GET",
        url: $("#url_valida_fecha").val(),
        data: {
            f1: $("#fecha_prestamo").val(),
            f2: $("#fecha_devolucion").val(),
        },
        dataType: "json",
        success: function (response) {
            if (response.msj == "mayor") {
                $("#error-fechas").text(
                    "El rango de fechas no es valido. El día de devolución no puede superar mas de 5 días al día de préstamo"
                );
                $("#error-fechas").removeClass("oculto");
                // $('#fecha_prestamo').val(response.f1);
                // $('#fecha_devolucion').val(response.f2);
                $("#registrarVenta").prop("disabled", true);
                $("#rango_dias").val("");
            } else if (response.msj == "menor") {
                $("#error-fechas").text(
                    "El rango de fechas no es valido. El día de devolución no puede ser igual o menor al día de préstamo"
                );
                $("#error-fechas").removeClass("oculto");
                // $('#fecha_prestamo').val(response.f1);
                // $('#fecha_devolucion').val(response.f2);
                $("#registrarVenta").prop("disabled", true);
                $("#rango_dias").val("");
            } else {
                // SI ES CORRECTO
                // OBTENER LA CANTIDAD DE DÍAS Y REDEFINIR LOS COSTOS
                $("#rango_dias").val(response.intervalo);
                defineCosto(response.intervalo);
                // RECALCULAR LOS TOTALES
                sumaTotal();
                $("#registrarVenta").prop("disabled", false);
                $("#error-fechas").addClass("oculto");
            }
        },
    });
}

function defineCosto(dias) {
    filas = $("#lista_detalle").children("tr.fila");
    filas.each(function () {
        let td_precio = $(this).children("td").eq(2);
        let td_total = $(this).children("td").eq(3);
        let td_cantidad = $(this).children("td").eq(4);
        let precio = $(this).attr("data-cost" + dias);
        td_precio.text(precio);
        td_total.text(
            (parseFloat(precio) * parseInt(td_cantidad.text())).toFixed(2)
        );
    });
}

function sumaTotal() {
    filas = $("#lista_detalle").children("tr.fila");
    let total_cantidad = 0;
    let total_costo = 0;
    filas.each(function () {
        let cantidad = $(this).children("td").eq(3).text();
        let total = $(this).children("td").eq(5).text();
        total_cantidad += parseInt(cantidad);
        total_costo += parseFloat(total);
    });
    let fila_total = $("#lista_detalle").children("tr.total");
    fila_total.children("td").eq(1).text(total_cantidad);
    fila_total.children("td").eq(3).text(total_costo.toFixed(2));
    let total = parseFloat(fila_total.children("td").eq(3).text());
    let total_final = 0;
    total_final = total;
    $("#total_final").val(total_final.toFixed(2));
    valida();
}

function enumerar(contenedor, sw) {
    let filas = contenedor.children("tr.fila");
    let sin_registros = contenedor.children("tr.sin_registros");
    contador = 0;
    filas.each(function () {
        if (!$(this).hasClass("oculto")) {
            contador++;
            let tdNum = $(this).children("td").eq(0);
            tdNum.text(contador);
        }
    });
    if (contador > 0) {
        sin_registros.addClass("oculto");

        if (sw == "prestamos") {
            $("#registrarVenta").prop("disabled", false);
        }
    } else {
        sin_registros.removeClass("oculto");
    }
}

function limpiar() {
    fila_seleccionada = null;
    $("#url_info").val("");
    $("#data_cod").val("");
    $("#stock_disponible").val("");
    $("#nombre_producto").text("");
    $("#cantidad_productos").val("1");
    $("#error-cantidad").addClass("oculto");
    $("#error-stock").addClass("oculto");
}
