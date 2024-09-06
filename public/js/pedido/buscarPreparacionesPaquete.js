jQuery.noConflict();
jQuery(document).ready( function(){

    var salsas = [];
    var preparaciones = [];
    var bebidas = [];

    $('.prepararPaquete').on('click', function(e){

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

        $.ajax({

            type: 'POST',
            url: '/pedido/paquete/platillos',
            data:{

                'id' : id,

            },
            dataType: 'json',
            encode: true,

        }).done( function( respuesta){

            if( respuesta.exito ){

                if( respuesta.platillos && Array.isArray( respuesta.platillos ) && respuesta.platillos.length > 0 ){

                    html = '<p class="bg-info p-1 text-center fw-semibold fs-6 col-lg-12"><i class="fas fa-info-circle"></i> Elige el platillo a preparar del paquete</p>';

                    respuesta.platillos.forEach( function( platillo ){

                        html += '<div class="col-lg-3 col-md-6 col-sm-12 my-1">';
                        html += '<button type="button" class="btn btn-outline-secondary p-1 fs-5 fw-semibold d-flex justify-content-center align-items-center salsasPaquete" style="width: 100%; height: 100px;" data-value="'+platillo.nombre+'" data-toggle="modal" data-target="#modalSalsasPaquete" data-id="'+platillo.id+'">'+platillo.nombre+'</button>';
                        html += '</div>';
                
                    });

                    $("#contenedorPlatillosPaquete").empty();
                    $("#contenedorPlatillosPaquete").append( html );
            
                }

                if( respuesta.bebidas && Array.isArray( respuesta.bebidas ) && respuesta.bebidas.length > 0 ){

                    html += '<div class="col-lg-3 col-md-6 col-sm-12 my-1">';
                    html += '<button type="button" class="btn btn-outline-secondary p-1 fs-5 fw-semibold d-flex justify-content-center align-items-center bebidasPaquete" style="width: 100%; height: 100px;" data-id="'+paquete+'" data-value="'+id+'" data-toggle="modal" data-target="#modalBebidasPaquete">Bebidas</button>';
                    html += '</div>';

                    $("#contenedorPlatillosPaquete").empty();
                    $("#contenedorPlatillosPaquete").append( html );

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

    $(document).on('click', '.salsasPaquete', function(e){

        e.preventDefault();

        document.getElementById('modalPlatillosPaquete').style.display = 'none';
        document.getElementById('modalPlatillosPaquete').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalSalsasPaquete').style.display = 'none';
        document.getElementById('modalSalsasPaquete').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalSalsasPaquete').style.display = 'block';
        document.getElementById('modalSalsasPaquete').classList.add('show');

        var id = $(this).attr('data-id');
        var platillo = $(this).attr('data-value');

        $("#idPlatilloPaqueteSalsa").val( id );

        $.ajax({

            type: 'POST',
            url: '/pedido/platillo/salsas',
            data: {

                'id': id,

            },
            dataType: 'json',
            encode: true,

        }).done( function( respuesta ){

            if( respuesta.exito ){

                $("#nombrePaquetePlatilloSalsa").val( platillo );

                if( respuesta.salsas && respuesta.salsas.length > 0 ){

                    var html = '<p class="bg-info p-1 fw-semibold fs-6">Salsas. <u>Máximo '+$("#limiteSalsasPaquete").val()+'</u></p>';

                    respuesta.salsas.forEach( function( salsas ){

                        html += '<div class="col-lg-4 col-md-6 col-sm-12">';
                        html += '<div class="form-check form-switch my-1">';
                        html += '<input type="checkbox" class="form-check-input" role="switch" id="salsa'+salsas.id+'" name="salsa" value="'+salsas.nombre+'" />';
                        html += '<label class="form-check-label" for="salsa'+salsas.id+'">'+salsas.nombre+'</label>';
                        html += '</div>';
                        html += '</div>';

                    });

                    $("#contenedorSalsasPaquete").empty();
                    $("#contenedorSalsasPaquete").append( html );

                    $("input[name=salsa]").change(function() {

                        salsas = $("input[name=salsa]:checked").map(function() {

                            return $(this).val();

                        }).get();

                        if( salsas.length > $("#limiteSalsasPaquete").val() ){

                            Swal.fire({

                                icon: 'info',
                                title: 'Máximo '+$("#limiteSalsasPaquete").val()+' salsa(s).',
                                showConfirmButton: true,
                                allowOutsideClick: false,

                            });

                            $(this).prop('checked', false);

                            $("input[name=salsa]").each(function() {
                            
                                if (!$(this).is(':checked')) {
                                    
                                    salsas = salsas.filter(salsa => salsa !== $(this).val());
                                }
    
                            });

                        }

                    });

                }else{

                    html = '<p class="p-1 shadow text-center bg-danger fw-semibold fs-5">Sin salsas para elegir.</p>';

                    $("#contenedorSalsasPaquete").empty();
                    $("#contenedorSalsasPaquete").append( html );

                }

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true,

                });

            }

        });

    });

    $(document).on('click', '#cancelarSalsasPaquete', function( e ){

        e.preventDefault();

        document.getElementById('modalSalsasPaquete').style.display = 'none';
        document.getElementById('modalSalsasPaquete').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalPlatillosPaquete').style.display = 'block';
        document.getElementById('modalPlatillosPaquete').classList.add('show');

    });
    
    $(document).on('click', ".bebidasPaquete", function(e){

        e.preventDefault();

        document.getElementById('modalPlatillosPaquete').style.display = 'none';
        document.getElementById('modalPlatillosPaquete').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalBebidasPaquete').style.display = 'block';
        document.getElementById('modalBebidasPaquete').classList.add('show');

        var paquete = $(this).attr('data-id');
        var id = $(this).attr('data-value');

        $("#nombrePlatilloBebidas").val( paquete );

        $.ajax({

            type: 'POST',
            url: '/pedido/paquete/bebidas',
            data:{

                'id': id,

            },
            dataType: 'json',
            encode: true,
        }).done( function( respuesta ){

            if( respuesta.exito ){

                if( respuesta.bebidas && respuesta.bebidas.length > 0 ){

                    html = '<p class="bg-info p-1 col-lg-12">Bebidas. <u>Máximo '+$("#limiteBebidasPaquete").val()+'</u></p>';

                    respuesta.bebidas.forEach( function( bebida ){

                        html += '<div class="col-lg-4 col-md-6 col-sm-12">';
                        html += '<div class="form-check form-switch my-1">';
                        html += '<input type="checkbox" class="form-check-input" role="switch" id="bebida'+bebida.id+'" name="bebida" value="'+bebida.nombre+'" />';
                        html += '<label class="form-check-label" for="bebida'+bebida.id+'">'+bebida.nombre+'</label>';
                        html += '</div>';
                        html += '</div>';

                    });

                    $("#contenedorBebidasPaquete").empty();
                    $("#contenedorBebidasPaquete").append( html );

                    $("input[name=bebida]").change(function() {

                        bebidas = $("input[name=bebida]:checked").map(function() {

                            return $(this).val();

                        }).get();

                        if( bebidas.length > $("#limiteBebidasPaquete").val() ){

                            Swal.fire({

                                icon: 'info',
                                title: 'Máximo '+$("#limiteBebidasPaquete").val()+' bebida(s).',
                                showConfirmButton: true,
                                allowOutsideClick: false,

                            });

                            $(this).prop('checked', false);

                            $("input[name=bebida]").each(function() {
                            
                                if (!$(this).is(':checked')) {
                                    
                                    bebidas = bebidas.filter(bebida => bebida !== $(this).val());
                                }
    
                            });

                        }

                    });

                }else{

                    html = '<p class="p-1 text-center bg-danger shadow fw-semibold fs-5">Sin bebidas para elegir.</p>';

                    $("#contenedorBebidasPaquete").empty();
                    $("#contenedorBebidasPaquete").append( html );

                }

            }else{

            }

        });

    });

    $("#salsasPlatilloPaquete").on('click', function(e){

        e.preventDefault();

        document.getElementById('modalSalsasPaquete').style.display = 'none';
        document.getElementById('modalSalsasPaquete').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalPreparacionesPaquete').style.display = 'block';
        document.getElementById('modalPreparacionesPaquete').classList.add('show');

        var id = $("#idPlatilloPaqueteSalsa").val();
        $("#idPlatilloPaquetePreparaciones").val( id );
        $("#nombrePlatilloPaquetePrep").val( $("#nombrePaquetePlatilloSalsa").val() );

        $.ajax({

            type: 'POST',
            url: '/pedido/platillo/preparaciones',
            data:{

                'id' : id,

            },
            dataType: 'json',
            encode: true,

        }).done( function( respuesta){

            if( respuesta.exito ){

                if( respuesta.preparaciones && respuesta.preparaciones.length > 0 ){

                    var html = '<p class="p-1 bg-info d-block col-lg-12">Ingrediente(s)</p>';

                    respuesta.preparaciones.forEach( function( preparacion ){

                        html += '<div class="col-lg-4 col-md-6 col-sm-12">'
                        html += '<div class="form-check form-switch my-1">';
                        html += '<input type="checkbox" class="form-check-input" role="switch" id="preparacion'+preparacion.id+'" name="preparacion" value="'+preparacion.nombre+'">';
                        html += '<label class="form-check-label" for="preparacion'+preparacion.id+'">'+preparacion.nombre+'</label>';
                        html += '</div>';
                        html += '</div>';

                    });

                    $("#contenedorPreparacionesPaquete").empty();
                    $("#contenedorPreparacionesPaquete").append( html );

                    $("input[name=preparacion]").change(function() {

                        preparaciones = $("input[name=preparacion]:checked").map(function() {

                            return $(this).val();

                        }).get();

                    });

                }else{

                    html = '<p class="text-center bg-danger fw-semibol fs-5">Sin ingredientes para elegir. Pulsa el botón "Agregar" para continuar</p>';

                    $("#contenedorPreparacionesPaquete").empty();
                    $("#contenedorPreparacionesPaquete").append( html );

                }

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    showConfirmButton: true,
                    allowOutsideClick: false,

                });

            }

        });

    });

    $(document).on('click', '#cancelarPreparacionesPaquete', function( e ){

        e.preventDefault();

        document.getElementById('modalPreparacionesPaquete').style.display = 'none';
        document.getElementById('modalPreparacionesPaquete').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalSalsasPaquete').style.display = 'block';
        document.getElementById('modalSalsasPaquete').classList.add('show');

    });

    $(document).on('click', '#cancelarPaquete', function( e ){

        e.preventDefault();

        document.getElementById('modalPlatillosPaquete').style.display = 'none';
        document.getElementById('modalPlatillosPaquete').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

    });

    $(document).on('click', '#preparacionesPlatilloPaquete, #bebidasPlatilloPaquete', function( e ){

        e.preventDefault();

        var procesamiento;

        Swal.fire({

            title: 'Agregando Preparativos',
            html: 'Un momento por favor: <b></b>',
            timer: 9999,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                procesamiento = setInterval( ()=>{

                    b.textContent = Swal.getTimerLeft();

                }, 100);

                $.ajax({

                    type: 'POST',
                    url: '/pedido/paquete/ordenar',
                    data:{

                        'platillo': $("#idPlatilloPaquetePreparaciones").val(),
                        'paquete' : $("#idPaquete").val(),
                        'salsas' : salsas,
                        'preparaciones' : preparaciones,
                        'bebidas' : bebidas,

                    },
                    dataType: 'json',
                    encode: true,

                }).done( function( respuesta ){

                    if( respuesta.exito ){

                        if( respuesta.url ){

                            Swal.fire({

                                icon: 'success',
                                title: 'Paquete Terminado',
                                allowOutsideClick: false,
                                showConfirmButton: true,

                            }).then( ( resultado )=>{

                                if( resultado.isConfirmed ){

                                    window.location.href = respuesta.url;

                                }

                            });

                        }else{

                            Swal.fire({

                                icon: 'success',
                                title: 'Ingredientes agregados',
                                allowOutsideClick: false,
                                showConfirmButton: true,
    
                            });
    
                            document.getElementById('modalSalsasPaquete').style.display = 'none';
                            document.getElementById('modalSalsasPaquete').classList.remove('show');
                            document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);
    
                            document.getElementById('modalPreparacionesPaquete').style.display = 'none';
                            document.getElementById('modalPreparacionesPaquete').classList.remove('show');
                            document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);
    
                            document.getElementById('modalPlatillosPaquete').style.display = 'block';
                            document.getElementById('modalPlatillosPaquete').classList.add('show');

                        }

                    }else{

                        Swal.fire({

                            icon: 'error',
                            title: respuesta.mensaje,
                            allowOutsideClick: false,
                            showConfirmButton: true,

                        }).then( (resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/pedido/menu';

                            }

                        });

                    }

                });

            },
            willClose: ()=>{

                clearInterval( procesamiento );

            }

        }).then( function( resultado ){

            if( resultado.dismiss == Swal.DismissReason.timer ){

                Swal.fire({

                    icon: 'warning',
                    title: 'Hubo un inconveniente. Trata de nuevo',
                    allowOutsideClick: false,
                    showConfirmButton: true,

                }).then( (resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/pedido/menu';

                    }

                });

            }

        });

    });

});