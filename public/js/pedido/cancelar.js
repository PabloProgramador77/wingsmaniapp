jQuery.noConflict();
jQuery(document).ready(function(){

    $("#cancelar").on('click', function(e){

        e.preventDefault();

        Swal.fire({

            icon: 'warning',
            title: '¿En verdad deseas cancelar tu pedido?',
            html: 'Deberas crear un nuevo pedido si deseas ordenar.',
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

                        'id' : $("#idPedido").val()

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

                                window.location.href = '/home';

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

            }

        });

    });

});