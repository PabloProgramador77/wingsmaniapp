jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizarTelefono").attr('disabled', true);

    $(".editarTelefono").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/telefono/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#telefonoEditar").val( respuesta.telefono );
                $("#idTelefono").val( respuesta.id );

                $("#actualizarTelefono").attr('disabled', false);

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/profile/username';

                    }

                });

                $("#actualizarTelefono").attr('disabled', true);

            }

        });

    });

});