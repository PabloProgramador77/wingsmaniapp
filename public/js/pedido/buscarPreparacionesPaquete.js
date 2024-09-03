jQuery.noConflict();
jQuery(document).ready( function(){

    $('.prepararPaquete').on('click', function(e){

        var salsas = [];
        var preparaciones = [];

        e.preventDefault();

        var id = $(this).attr('data-id');
        var paquete = $(this).attr('data-value').split(',')[0];
        var limiteBebidas = $(this).attr('data-value').split(',')[1];
        var limiteSalsas = $(this).attr('data-value').split(',')[2];
        var limiteEditables = $(this).attr('data-value').split(',')[3];

        $('#nombrePaquetePrep').val( paquete );
        $("#idPaquete").val( id );
        $("#limiteSalsasPaquete").val( limiteSalsas );
        $("#limiteBebidasPaquete").val( limiteBebidas );
        $("#limiteEditablesPaquete").val( limiteEditables );
        console.log( $(this).attr('data-value') );

        $.ajax({

            type: 'POST',
            url: '/pedido/paquete/preparaciones',
            data:{

                'id' : id,

            },
            dataType: 'json',
            encode: true,

        }).done( function( respuesta){

            if( respuesta.exito ){

                if( respuesta.platillos && Array.isArray( respuesta.platillos ) && respuesta.platillos.length > 0 ){

                    var html = '';

                    respuesta.platillos.forEach( function( platillo, i){

                        if( platillo.salsas.length > 0 || platillo.preparaciones.length > 0 ){

                            html += '<div class="carousel-item'+( i === 0 ? ' active': '')+'"><p class="p-2 my-1 text-center bg-info">'+platillo.nombre+'</p>';
                            html += '<input type="hidden" id="PlatilloPaquete" value="'+platillo.nombre+'">'

                            if( platillo.salsas && Array.isArray( platillo.salsas ) && platillo.salsas.length > 0 ){

                                html += '<p class="col-lg-12 bg-secondary">Salsas. <b>Máximo '+limiteSalsas+'</b></p>';

                                platillo.salsas.forEach( function( salsa ){

                                    html += '<div class="form-check form-switch col-lg-4 col-md-6 col-sm-12 my-1">';
                                    html += '<input type="checkbox" class="form-check-input" role="switch" id="salsa'+salsa.id+'" name="salsa" value="'+salsa.nombre+'">';
                                    html += '<label class="form-check-label" for="salsa'+salsa.id+'">'+salsa.nombre+'</label>';
                                    html += '</div>';

                                });

                            }

                            if( platillo.preparaciones && Array.isArray( platillo.preparaciones ) && platillo.preparaciones.length > 0 ){

                                html += '<p class="col-lg-12 bg-secondary">Ingredientes</p>';

                                platillo.preparaciones.forEach( function( preparacion ){

                                    html += '<div class="form-check form-switch col-lg-4 col-md-6 col-sm-12 my-1">';
                                    html += '<input type="checkbox" class="form-check-input" role="switch" id="preparacion'+preparacion.id+'" name="preparacion" value="'+preparacion.nombre+'">';
                                    html += '<label class="form-check-label" for="preparacion'+preparacion.id+'">'+preparacion.nombre+'</label>';
                                    html += '</div>';

                                });

                            }

                            if( respuesta.bebidas && Array.isArray( respuesta.bebidas ) && respuesta.bebidas.length > 0 ){

                                html += '<p class="p-1 my-1 text-center bg-info">Bebidas</p>';
                                html += '<p class="col-lg-12 bg-secondary">Elige las bebidas. <b>Máximo '+limiteBebidas+'</b></p>';

                                respuesta.bebidas.forEach( function( bebida ){

                                    html += '<div class="form-check form-switch col-lg-4 col-md-6 col-sm-12 my-1">';
                                    html += '<input type="checkbox" class="form-check-input" role="switch" id="bebida'+bebida.id+'" name="bebida" value="'+bebida.nombre+'">';
                                    html += '<label class="form-check-label" form="bebida'+bebida.id+'">'+bebida.nombre+'</label>';
                                    html += '</div>';

                                });

                            }

                            html += '</div>';

                        }

                    });

                    $("#contenedorPlatillosPaquete").empty();
                    $("#contenedorPlatillosPaquete").html( html );

                }

            }else{

                $("#prepararPaquete").attr('disabled', true);

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true,

                });

            }

        });

    });

});