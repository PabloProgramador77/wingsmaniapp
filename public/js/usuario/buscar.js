jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/usuario/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreEditar").val( respuesta.nombre );
                $("#emailEditar").val(respuesta.email);

                $("#rolEditar").prepend('<option value="'+respuesta.rol+'">'+respuesta.rol+'</option>');
                $("#rolEditar").val(respuesta.rol);
                $("#rolEditar option[value='"+respuesta.rol+"']:not(:first)").remove();

                $("#id").val( respuesta.id );

                $("#actualizar").attr('disabled', false);

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/usuarios';

                    }

                });

                $("#actualizar").attr('disabled', true);

            }

        });

    });

});