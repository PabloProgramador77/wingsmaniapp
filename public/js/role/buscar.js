jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/role/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreEditar").val( respuesta.nombre );
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

                        window.location.href = '/roles';

                    }

                });

                $("#actualizar").attr('disabled', true);

            }

        });

    });

    $(".permisos").on('click', function(e){

        e.preventDefault();

        $('input[type=checkbox]').prop('checked', false);

        $.ajax({

            type: 'POST',
            url: '/role/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreRol").val( respuesta.nombre );
                $("#idRol").val( respuesta.id );

                $("#permitir").attr('disabled', false);

                $.each(respuesta.permisos, function(i, permiso){

                    $('input[type=checkbox][id="'+permiso.id+'"]').prop('checked', true);

                });

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/roles';

                    }

                });

                $("#permitir").attr('disabled', true);

            }

        });

    });

});