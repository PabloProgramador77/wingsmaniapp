jQuery.noConflict();
jQuery(document).ready(function(){

    $(".envios").on('click', function(e){

        var cliente = $(this).attr('data-value');
        var idPedido = $(this).attr('data-id');

        $("#cliente").val( cliente );

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/pedido/domicilio',
            data:{

                'id' : idPedido 

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                Swal.fire({

                    icon: 'success',
                    title: 'Impreso y Cliente Notificado',
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/pedidos';

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

                        window.location.href = '/pedidos';

                    }

                });

            }

        });

    });

});