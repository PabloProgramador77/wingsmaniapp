jQuery.noConflict();
jQuery(document).ready( function(){

    $('.prepararPlatillo').on('click', function(e){

        var salsas = [];
        var preparaciones = [];

        e.preventDefault();

        console.log( $(this).data('value') );

        var id = $(this).attr('data-id');
        var platillo = $(this).data('value').split(',')[0];
        var limiteSalsas = $(this).data('value').split(',')[1];

        $('#nombrePlatilloPrep').val( platillo );
        $("#idPlatillo").val( id );
        $("#limiteSalsas").val( limiteSalsas );

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

                if( respuesta.salsas && respuesta.salsas.length > 0 ){

                    var html = '<p class="p-1 bg-info d-block col-lg-12">Salsa(s)</p>';

                    respuesta.salsas.forEach( function( salsa){

                        html += '<div class="form-check form-switch col-lg-3 col-md-6 col-sm-12 my-1">';
                        html += '<input type="checkbox" class="form-check-input" role="switch" id="salsa'+salsa.id+'" name="salsa" value="'+salsa.nombre+'">';
                        html += '<label class="form-check-label" for="salsa'+salsa.id+'">'+salsa.nombre+'</label>';
                        html += '</div>';

                    });

                    $("#contenedorSalsasPlatillo").empty();
                    $("#contenedorSalsasPlatillo").append( html );

                    $("input[name=salsa]").change(function() {

                        salsas = $("input[name=salsa]:checked").map(function() {

                            return $(this).val();

                        }).get();

                    });

                }

                if( respuesta.preparaciones && respuesta.preparaciones.length > 0 ){

                    var html = '<p class="p-1 bg-info d-block col-lg-12">Preparaciones</p>';

                    respuesta.preparaciones.forEach( function( preparacion){

                        html += '<div class="form-check form-switch col-lg-3 col-md-6 col-sm-12 my-1">';
                        html += '<input type="checkbox" class="form-check-input" role="switch" id="preparacion'+preparacion.id+'" name="preparacion" value="'+preparacion.nombre+'">';
                        html += '<label class="form-check-label" for="preparacion'+preparacion.id+'">'+preparacion.nombre+'</label>';
                        html += '</div>';

                    });

                    $("#contenedorPreparacionesPlatillo").empty();
                    $("#contenedorPreparacionesPlatillo").append( html );

                    $("input[name=preparacion]").change(function() {
                        
                        preparaciones = $("input[name=preparacion]:checked").map(function() {
                            
                            return $(this).val();
                        
                        }).get();

                    });

                }

                $("#prepararPlatillo").attr('disabled', false);

                $("#prepararPlatillo").on('click', function(e){

                    e.preventDefault();
            
                    let procesamiento;

                    console.log( salsas, preparaciones );
            
                    if( salsas.length <= 0 ){
            
                        Swal.fire({
                    
                            icon: 'info',
                            title: 'Elige por lo menos 1 salsa.',
                            allowOutsideClick: false,
                            showConfirmButton: true
            
                        });
            
                    }else{
            
                        if( salsas.length > $("#limiteSalsas").val() ){
            
                            Swal.fire({
                
                                icon: 'error',
                                title: 'Solo se permiten máximo '+$("#limiteSalsas").val()+' salsas.',
                                allowOutsideClick: false,
                                showConfirmButton: true
                
                            });
                
                        }else{
                
                            Swal.fire({
                
                                title: 'Preparando',
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
                    
                                            'id' : $("#idPlatillo").val(),
                                            'salsas' : salsas,
                                            'preparaciones' : preparaciones,
                    
                                        },
                                        dataType: 'json',
                                        encode: true
                    
                                    }).done(function(respuesta){
                    
                                        if( respuesta.exito ){
                    
                                            Swal.fire({
                    
                                                icon: 'success',
                                                title: 'Platillo Preparado',
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
                
                        }
            
                    }
            
                });

            }else{

                $("#prepararPlatillo").attr('disabled', true);

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