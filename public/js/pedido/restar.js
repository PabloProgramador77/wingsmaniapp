jQuery.noConflict();
jQuery(document).ready(function(){

    $(".restar").on('click', function(e){

        var dataId = $(this).attr('data-id');

        if( $("#cantidadPlatillo[data-id='"+dataId+"']").text() == '1' ){

            e.preventDefault();

            $(this).attr('disabled', true);

        }else{

            e.preventDefault();

            $.ajax({

                type: 'POST',
                url: '/pedido/restar',
                data:{

                    'id' : $(this).attr('data-id'),

                },
                dataType: 'json',
                encode: true

            }).done(function(respuesta){

                if( respuesta.exito ){

                    if( respuesta.cantidad == 1 ){

                        $(".restar[data-id='"+dataId+"']").attr('disabled', true);

                    }else{

                        $(".restar[data-id='"+dataId+"']").attr('disabled', false);

                    }

                    $("#cantidadPlatillo[data-id='"+dataId+"']").text( respuesta.cantidad );
                    $("#totalPedido").text('Total: $ '+respuesta.total);

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

        }

    });

});