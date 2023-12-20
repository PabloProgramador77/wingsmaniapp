jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editarDomicilio").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/domicilio/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#direccionEditar").val( respuesta.direccion );
                $("#idDomicilio").val( respuesta.id );

                $("#actualizar").attr('disabled', false);

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

                $("#actualizar").attr('disabled', true);

            }

        });

    });

});