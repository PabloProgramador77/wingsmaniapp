jQuery.noConflict();
jQuery(document).ready(function(){

    $(".sumarPaquete").on('click', function(){

        var dataId = $(this).attr('data-id');

        $.ajax({

            type: 'POST',
            url: '/paquete/sumar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.cantidad == 1 ){

                    $(".restarPaquete[data-id='"+dataId+"']").attr('disabled', true);

                }else{

                    $(".restarPaquete[data-id='"+dataId+"']").attr('disabled', false);

                }

                $("#cantidadPaquete[data-id='"+dataId+"']").text( respuesta.cantidad );
                $("#totalPedido").text('Total: $ ' + respuesta.total + ' MXN');

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

    });

});