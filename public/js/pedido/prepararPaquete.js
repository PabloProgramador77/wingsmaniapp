jQuery.noConflict();
jQuery(document).ready(function(){

    $("#continuar").on('click', function(e){

        var salsas = new Array();
        var preparaciones = new Array();

        e.preventDefault();

        let procesamiento;

        $("input[name=salsa]:checked").each(function(){

            salsas.push($(this).attr('data-id'));

        });

        $("input[name=preparacion]:checked").each(function(){

            preparaciones.push($(this).attr('data-id'));

        });

        Swal.fire({
    
            title: 'Preparando...',
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
                    url: '/paquete/preparar',
                    data:{

                        'id' : $("#id").val(),
                        'salsas' : salsas,
                        'preparaciones' : preparaciones,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Paquete Preparado',
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