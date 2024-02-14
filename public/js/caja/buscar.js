jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/caja/buscar',
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

                        window.location.href = '/cajas';

                    }

                });

                $("#actualizar").attr('disabled', true);

            }

        });

    });

    $(".abrir").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/caja/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreCaja").val( respuesta.nombre );
                $("#idCaja").val( respuesta.id );

                $("#abrir").attr('disabled', false);

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/cajas';

                    }

                });

                $("#abrir").attr('disabled', true);

            }

        });

    });

    $(".cerrar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/caja/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreCaja").val( respuesta.nombre );
                $("#idCaja").val( respuesta.id );
                $("#totalCaja").val( respuesta.total );

                $("#abrir").attr('disabled', false);

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/cajas';

                    }

                });

                $("#abrir").attr('disabled', true);

            }

        });

    });

});