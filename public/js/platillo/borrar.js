jQuery.noConflict();
jQuery(document).ready(function(){

    $(".eliminar").on('click', function(e){

        e.preventDefault();

        Swal.fire({

            icon: 'warning',
            title: '¿En verdad deseas borrar el platillo '+ $(this).attr('data-value') +'?',
            html: 'Los datos no podrán ser recuperados de ninguna manera.',
            allowOutsideClick: false,
            confirmButtonText: 'Si, borralo',
            showConfirmButton: true,
            showDenyButton: true,

        }).then((resultado)=>{

            if( resultado.isConfirmed ){

                $.ajax({

                    type: 'POST',
                    url: '/platillo/borrar',
                    data:{

                        'id' : $(this).attr('data-id'),

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Platillo Borrado.',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/platillos';

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

                                window.location.href = '/platillos';

                            }

                        });

                    }

                });

            }

        });

    });

});