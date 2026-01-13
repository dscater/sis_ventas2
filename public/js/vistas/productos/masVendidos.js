let listProductos = $('#listProductos');
let filtro_vendidos = $('#filtro_vendidos');
let cantidad_filtro = $("#cantidad_filtro");
let filtro_productos = [];
let datos = [];
let datos_copia = [];
let btnLimpiar = $("#btnLimpiar");

let fila = `<div class="fila" data-id="0"></div>`;
let btnAgregar = $("#btnAgregar");
let contenedor_filtrados = $("#contenedor_filtrados");
let anchoExportacion = $("#anchoExportacion").val();
let altoExportacion = $("#altoExportacion").val();

$(document).ready(function () {
    reiniciaFechas();
    cargaDatos();
    $('#filtro').change(function () {
        let filtro = $(this).val();
        if (filtro != 1) {
            $('#fecha_ini').removeClass('oculto');
            $('#fecha_fin').removeClass('oculto');
            cargaDatos();
        }
        else {
            $('#fecha_ini').addClass('oculto');
            $('#fecha_fin').addClass('oculto');
            reiniciaFechas();
            cargaDatos();
        }
    });

    $('#fecha_ini').change(cargaDatos);
    // $('#fecha_ini').keyup(cargaDatos);

    $('#fecha_fin').change(cargaDatos);
    // $('#fecha_fin').keyup(cargaDatos);

    filtro_vendidos.change(cargaDatos);

    cantidad_filtro.on("keyup change", cargaDatos);

    btnLimpiar.click(function () {
        filtro_productos = [];
        contenedor_filtrados.html(`<div class="vacio">No se filtro ningún producto aún</div>`);
        cargaDatos();
    });


    btnAgregar.click(function () {
        if (listProductos.val() != "") {
            // comprobar existencia del array
            if (!filtro_productos.includes(listProductos.val())) {
                // existe vacio
                if (contenedor_filtrados.children(".vacio").length > 0) {
                    contenedor_filtrados.html("");
                }
                let nueva_fila = $(fila).clone();
                nueva_fila.attr("data-id", listProductos.val());
                nueva_fila.html(listProductos.children("option:selected").text());
                filtro_productos.push(listProductos.val());
                contenedor_filtrados.append(nueva_fila);
                cargaDatos();
            }
        }
    });

    contenedor_filtrados.on("click", ".fila", function () {
        let id = $(this).attr("data-id");
        console.log(id);
        let index = filtro_productos.indexOf(id);
        console.log(index);
        if (index > -1) {
            filtro_productos.splice(index, 1);
            $(this).remove();
            if (contenedor_filtrados.children(".fila").length == 0) {
                contenedor_filtrados.html(`<div class="vacio">No se filtro ningún producto aún</div>`);
            }
            cargaDatos();
        }
    });

});

function reiniciaFechas() {
    $('#fecha_ini').val($('#fecha_hoy').val());
    $('#fecha_fin').val($('#fecha_hoy').val());
}

var hoy = new Date();
var fecha_actual = ("0" + hoy.getDate()).slice(-2) + "-" + ("0" + (hoy.getMonth() + 1)).slice(-2) + "-" + hoy.getFullYear();

function cargaDatos() {
    $.ajax({
        type: "GET",
        url: $('#urlEstadisticas').val(),
        data: {
            filtro: $('#filtro').val(),
            fecha_ini: $('#fecha_ini').val(),
            fecha_fin: $('#fecha_fin').val(),
            filtro_vendidos: filtro_vendidos.val(),
            cantidad_filtro: cantidad_filtro.val(),
            filtro_productos: filtro_productos
        },
        dataType: "json",
        success: function (response) {
            datos_copia = response.datos;
            datos = response.datos;
            // SETEAR EL CONTENEDOR, TIPO Y TITULO DEL GRÁFICO
            // options.chart = new Object();
            var options = {
                chart: {
                    renderTo: 'contenedor_grafico',
                    type: 'column',
                    zoomType: "y",
                },
                title: {
                    text: 'PRODUCTOS VENDIDOS'
                },
                subtitle: {
                    text: 'Fecha: ' + fecha_actual
                },
                xAxis: {
                    categories: ['Unidades Vendidas']
                },
                yAxis: {
                    title: {
                        text: 'Cantidad vendida'
                    }
                },
                legend: {
                    enabled: true,
                },
                exporting: {
                    enabled: true,
                    // scale: 100,
                    sourceHeight: altoExportacion && altoExportacion != '' ? altoExportacion : 700,
                    sourceWidth: anchoExportacion && anchoExportacion != '' ? anchoExportacion : 1400,
                    // allowHTML: true,
                    chartOptions: {
                        xAxis: [{
                            labels: {
                                style: {
                                    fontSize: '7px'
                                }
                            }
                        }]
                    },
                },
                // exporting: {
                //     scale: 1,
                //     width: 300,
                //     allowHTML: true
                // }
            };

            options.plotOptions = {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                },
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                    },
                },
            };

            // SETEAR LOS VALORES
            options.series = datos


            // INICIALIZAR GRÁFICOS
            var chart = new Highcharts.Chart(options);
        }
    });
}