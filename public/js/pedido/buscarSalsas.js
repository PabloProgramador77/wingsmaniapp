jQuery.noConflict();
jQuery(document).ready( function(){

    var salsas = [];
    var preparaciones = [];

    $('.prepararPlatillo').on('click', function(e){

        e.preventDefault();

        console.log( $(this).data('value') );

        var id = $(this).attr('data-id');
        var platillo = $(this).attr('data-value').split(',')[0];
        var limiteSalsas = $(this).attr('data-value').split(',')[1];

        $('#nombrePlatilloSalsa').val( platillo );
        $("#idPlatilloSalsa").val( id );
        $("#limiteSalsas").val( limiteSalsas );

        $.ajax({

            type: 'POST',
            url: '/pedido/platillo/salsas',
            data:{

                'id' : id,

            },
            dataType: 'json',
            encode: true,

        }).done( function( respuesta){

            if( respuesta.exito ){

                if( respuesta.salsas && respuesta.salsas.length > 0 ){

                    var html = '<p class="p-1 bg-info d-block col-lg-12 rounded">Salsa(s). <b>Máximo '+limiteSalsas+'</b></p>';

                    respuesta.salsas.forEach( function( salsa){

                        html += '<div class="col-lg-4 col-md-6 col-sm-12">'
                        html += '<div class="form-check form-switch my-1">';
                        html += '<input type="checkbox" class="form-check-input" role="switch" id="salsa'+salsa.id+'" name="salsa" value="'+salsa.nombre+'">';
                        html += '<label class="form-check-label" for="salsa'+salsa.id+'">'+salsa.nombre+'</label>';
                        html += '</div>';
                        html += '</div>';

                    });

                    $("#contenedorSalsasPlatillo").empty();
                    $("#contenedorSalsasPlatillo").append( html );

                    $("input[name=salsa]").change(function() {

                        salsas = $("input[name=salsa]:checked").map(function() {

                            return $(this).val();

                        }).get();

                        if( salsas.length > $("#limiteSalsas").val() ){

                            Swal.fire({

                                icon: 'info',
                                title: 'Máximo '+$("#limiteSalsas").val()+' salsa(s).',
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

                    html = '<p class="text-center bg-danger fw-semibold fs-6 shadow rounded">Sin salsas para elegir. Presiona el botón "Continuar" por favor.</p>';

                    $("#contenedorSalsasPlatillo").empty();
                    $("#contenedorSalsasPlatillo").append( html );

                    $("#salsasPlatillo").text('Continuar');
                    $("#cancelarSalsas").attr('disabled', true);
                    
                }

                $("#salsasPlatillo").attr('disabled', false);

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    showConfirmButton: true,
                    allowOutsideClick: false,

                });

                $("#salsasPlatillo").attr('disabled', true);

            }

        });

    });

    $("#cancelarSalsas").on('click', function(e){

        e.preventDefault();

        document.getElementById('modalSalsas').style.display = 'none';
        document.getElementById('modalSalsas').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

    });

    $('#salsasPlatillo').on('click', function(e){

        e.preventDefault();

        document.getElementById('modalSalsas').style.display = 'none';
        document.getElementById('modalSalsas').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalPreparaciones').style.display = 'block';
        document.getElementById('modalPreparaciones').classList.add('show');

        console.log( $(this).data('value') );

        var id = $("#idPlatilloSalsa").val();
        var platillo = $("#nombrePlatilloSalsa").val();

        $('#nombrePlatilloPrep').val( platillo );
        $("#idPlatilloPrep").val( id );

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

                    $("#contenedorPreparacionesPlatillo").empty();
                    $("#contenedorPreparacionesPlatillo").append( html );

                    $("input[name=preparacion]").change(function() {

                        preparaciones = $("input[name=preparacion]:checked").map(function() {

                            return $(this).val();

                        }).get();

                    });

                }else{

                    html = '<p class="text-center bg-danger fw-semibold fs-6 shadow rounded">Sin ingredientes para elegir. Presiona el botón "Continuar" para terminar.</p>';

                    $("#contenedorPreparacionesPlatillo").empty();
                    $("#contenedorPreparacionesPlatillo").append( html );

                    $("#ingredientesPlatillo").text('Continuar');
                    $("#cancelarIngredientes").attr('disabled', true);

                }

                $("#ingredientesPlatillo").attr('disabled', false);

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    showConfirmButton: true,
                    allowOutsideClick: false,

                });

                $("#ingredientesPlatillo").attr('disabled', true);

            }

        });

    });

    $("#cancelarIngredientes").on('click', function(e){

        e.preventDefault();

        document.getElementById('modalPreparaciones').style.display = 'none';
        document.getElementById('modalPreparaciones').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalSalsas').style.display = 'block';
        document.getElementById('modalSalsas').classList.add('show');

    });

    $("#ingredientesPlatillo").on('click', function(e){

        e.preventDefault;

        Swal.fire({
                
            title: 'Preparando Platillo',
            html: 'Un momento por favor: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft();

                }, 100);

                $.ajax({

                    type: 'POST',
                    url: '/pedido/platillo/preparar',
                    data:{

                        'id' : $("#idPlatilloPrep").val(),
                        'salsas' : salsas,
                        'preparaciones' : preparaciones,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Platillo agregado',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/pedido/menu';

                            }

                        });

                    }else{

                        Swal.fire({

                            icon: 'error',
                            title: respuesta.mensaje,
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/pedido/menu';

                            }

                        });

                    }

                });

            },
            willClose: ()=>{

                clearInterval(procesamiento);

            }

        }).then(function(resultado){

            if( resultado.dismiss == Swal.DismissReason.timer ){

                Swal.fire({

                    icon: 'warning',
                    title: 'Hubo un inconveniente. Trata de nuevo.',
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/pedido/menu';

                    }

                });

            }
            
        });

    });

});