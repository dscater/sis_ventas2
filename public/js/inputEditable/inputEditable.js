(function($,document){
    'use strict';
    $.fn.inputEditable=function(){
        var contenedorPrincipal = $(this);
        var elementoActual = null;

        var btnOpciones = `
                        <div class="boton-opcion editar">
                            <i class="fa fa-edit"></i>
                        </div>

                        <div class="boton-opcion guardar oculto">
                            <i class="fa fa-check"></i>
                        </div>

                        <div class="boton-opcion cancelar oculto">
                            <i class="fa fa-times"></i>
                        </div>

                        <div class="boton-opcion cargando oculto">
                            <div class="overlay">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>`;
        contenedorPrincipal.each(function(){
            let htmlContenedor = $(this).html();
            htmlContenedor += `${btnOpciones}`;
            $(this).html(htmlContenedor);
            let input = $(this).children('form').children('.informacion');
            if(input.hasClass('input-tags')){
                activaTags(input);
            }
        });


        $(document).ready(function () {
    
            // COMPROBAR SI UN ELEMENTO NO FUE GUARDADO
            $(document).click(function(e){
                if(elementoActual != null)
                {
                    if(elementoActual.hasClass('oculto'))
                    {
                        let form = elementoActual.siblings('form');
                        let input = form.children('.informacion');
                        if(input.val() != elementoActual.attr('data-valor'))
                        {
                            updateInputs(elementoActual);
                        }
                        else{
                            muestraEditar(elementoActual);
                        }
                        elementoActual = null;
                    }
                    else{
                        elementoActual = null;
                    }
                }
            });
        
            // REHABILITAR LA EDICIÓN DE UN INPUT
            $(document).on('click','.elemento .contenedor-informacion .informacion',function(e){
                e.stopPropagation();
            });
            
            $(document).on('click','.elemento .contenedor-informacion form .bootstrap-tagsinput ',function(e){
                e.stopPropagation();
            });

            $(document).on('click','.elemento .contenedor-informacion .contenedor-editable',function(e){
                e.stopPropagation();
                let form = $(this).siblings('form');
                let informacion = form.children('.informacion');
                $(this).addClass('oculto');
                form.removeClass('oculto');
                informacion.val($(this).attr('data-valor'));
                mostrarBotonesCheckTimes($(this));
                
                guardaInputsSinGuardar($(this));
            });
        
            // REHABILITAR LA EDICIÓN DE UN INPUT CUANDO SE PRESIONA EL BOTON EDITAR
            $(document).on('click','.elemento .contenedor-informacion .boton-opcion.editar',function(e){
                e.stopPropagation();
                let form = $(this).siblings('form');
                let informacion = form.children('.informacion');
                let contenedorEditable = $(this).siblings('.contenedor-editable');
                informacion.parent().removeClass('oculto');
                contenedorEditable.addClass('oculto');
                informacion.val(contenedorEditable.attr('data-valor'));
                mostrarBotonesCheckTimes($(this));
                
                guardaInputsSinGuardar(contenedorEditable);
            });
        
            // CANCELAR CUANDO SE PRESIONA EL BOTON TIMES
            $(document).on('click','.elemento .contenedor-informacion .boton-opcion.cancelar',function(e){
                let contenedorInformacion = $(this).parents('.contenedor-informacion');
                let form = contenedorInformacion.children('form');
                let input = form.children('.informacion');
                input.val(input.attr('data-valor'));
        
                // MOSTRAR EDITAR
                muestraEditar($(this));
            });
        
            // GUARDAR LA INFORMACIÓN CUANDO SE PRESIONA EL BOTON CHECK
            $(document).on('click','.elemento .contenedor-informacion .boton-opcion.guardar',function(e){
                let form = $(this).siblings('form')
                let input = form.children('.informacion')
                let contenedorEditable = $(this).siblings('.contenedor-editable');
                if(input.val() != contenedorEditable.attr('data-valor'))
                {
                    updateInputs(contenedorEditable);
                }
                else{
                    guardaInputsSinGuardar(contenedorEditable);
                    muestraEditar($(this));
                }
            });
        });

        // FUNCION GUARDAR
        function updateInputs(elemento)
        {
            // mostrar cargando
            mostrarCargando(elemento);
            let index = elemento.attr('data-col');
            let url = elemento.parents('.elementos-editable').attr('data-url');
            if(elemento.attr('data-url') != undefined)
            {
                url = elemento.attr('data-url');
                console.log('XD');
            }

            //hermano input
            let form = elemento.siblings('form');
            let input = form.children('.informacion');
            let tipoTag = input.prop('tagName');
            console.log(form.html());
            var varData = form.serialize();
            varData += '&index='+index;
            console.log(varData);
            $.ajax({
                headers:{'X-CSRF-TOKEN':$('#token').val()},
                type: "PUT",
                url: url,
                data: varData,
                dataType: "json",
                success: function (response) {
                    input.val(response.valor);
                    elemento.attr('data-valor',response.valor);
                    elemento.html(response.valor); 
                    elemento.removeClass('oculto');
                    form.addClass('oculto');
                    muestraEditar(elemento);
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        //mostrar el boton editar
        function muestraEditar(elemento)
        {
            let contenedorInformacion = elemento.parents('.contenedor-informacion');

            let form = contenedorInformacion.children('form')
            let informacion = form.children('.informacion');
            let contenedorEditable = contenedorInformacion.children('.contenedor-editable');

            let editar = contenedorInformacion.children('.boton-opcion.editar');
            let cargando = contenedorInformacion.children('.boton-opcion.cargando');
            let guardar = contenedorInformacion.children('.boton-opcion.guardar');
            let cancelar = contenedorInformacion.children('.boton-opcion.cancelar');

            informacion.parent().addClass('oculto');
            contenedorEditable.removeClass('oculto');

            cargando.addClass('oculto');
            guardar.addClass('oculto');
            cancelar.addClass('oculto');
            editar.removeClass('oculto');
        }

        // oculta el boton editar y muestra los botones check y times
        function mostrarBotonesCheckTimes(elemento){
            let contenedorInformacion = elemento.parents('.contenedor-informacion')
            let form = contenedorInformacion.children('form')
            let input = form.children('.informacion')
            let editar = contenedorInformacion.children('.boton-opcion.editar')
            let guardar = contenedorInformacion.children('.boton-opcion.guardar')
            let cancelar = contenedorInformacion.children('.boton-opcion.cancelar')
            // FOCUS AL FINAL DEL INPUT
            let val = input.val();
            input.focus().val("").val(val);
            editar.addClass('oculto');

            // MOSTRAR LOS BOTONES CHECK Y TIMES
            guardar.removeClass('oculto');
            cancelar.removeClass('oculto');
        }

        //mumestra cargando y oculta los botones check y times
        function mostrarCargando(elemento){
            let contenedorInformacion = elemento.parents('.contenedor-informacion');
            let cargando = contenedorInformacion.children('.boton-opcion.cargando');
            let editar = contenedorInformacion.children('.boton-opcion.editar');
            let guardar = contenedorInformacion.children('.boton-opcion.guardar');
            let cancelar = contenedorInformacion.children('.boton-opcion.cancelar');
            cargando.removeClass('oculto');
            editar.addClass('oculto');
            guardar.addClass('oculto');
            cancelar.addClass('oculto');
        }

        // GUARDA INPUTS SIN GUARDAR
        function guardaInputsSinGuardar(contenedorEditable)
        {
            if(elementoActual != null)
            {
                if(elementoActual.hasClass('oculto'))
                {
                    let form = elementoActual.siblings('form');
                    let input = form.children('.informacion');

                    if(input.val() != elementoActual.attr('data-valor'))
                    {
                        updateInputs(elementoActual);
                    }
                    else{
                        muestraEditar(elementoActual);
                    }
                    elementoActual = contenedorEditable;
                }
                else{
                    elementoActual = null;
                }
            }
            else{
                elementoActual = contenedorEditable;
            }
        }

        function activaTags(input){
            input.tagsinput();
        }
    
    };
})(jQuery, document);