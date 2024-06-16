jQuery.noConflict();
jQuery(document).ready(function(){

    $(".cancelar").on('click', function(e){

        e.preventDefault();

        var id = $(this).attr('data-id');

        Swal.fire({

            icon: 'warning',
            title: '¿En verdad deseas cancelar el pedido de '+ $(this).attr('data-value') +'?',
            html: 'Los datos no podrán ser recuperados de ninguna forma.',
            allowOutsideClick: false,
            confirmButtonText: 'Si, cancelalo',
            showConfirmButton: true,
            showDenyButton: true,

        }).then((resultado)=>{

            if( resultado.isConfirmed ){

                $.ajax({

                    type: 'POST',
                    url: '/pedido/cancelar',
                    data:{

                        'id' : id

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Pedido Cancelado.',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = respuesta.url;

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

                                window.location.href = respuesta.url;

                            }

                        });

                    }

                });

            }

        });

    });

});