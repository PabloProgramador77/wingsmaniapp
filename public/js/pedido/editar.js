jQuery.noConflict();
jQuery(document).ready(function(){

    $('#editarPedido').on('click', function(){

        var pedido = $(this).attr('data-id');

        Swal.fire({

            icon: 'warning',
            title: '¿En verdad deseas editar el pedido de '+ $(this).attr('data-value') +'?',
            html: 'Confirma la acción.',
            allowOutsideClick: false,
            confirmButtonText: 'Si deseo editarlo',
            showConfirmButton: true,
            showDenyButton: true,

        }).then(function(resultado){

            if( resultado.isConfirmed ){

                $.ajax({

                    type: 'POST',
                    url: '/pedido/editar',
                    data:{

                        'pedido' : pedido,

                    },
                    dataType: 'json',
                    encode: true,

                }).done(function( respuesta ){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'info',
                            title: 'Edición Iniciada',
                            html: 'Ahora puedes editar el pedido y sus platillos',
                            allowOutsideClick: false,
                            showConfirmButton: true,

                        }).then( function(resultado){

                            if( resultado.isConfirmed ){

                                window.location.href = '/pedido/menu';

                            }

                        });

                    }else{

                        Swal.fire({

                            icon: 'error',
                            title: respuesta.mensaje,
                            html: 'Consulta al administrador del sistema',
                            allowOutsideClick: false,
                            showConfirmButton: true,

                        }).then( function(resultado){

                            if( resultado.isConfirmed ){

                                window.location.href = '/pedidos';

                            }

                        });

                    }

                });

            }

        });

    });

});