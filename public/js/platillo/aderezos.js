jQuery.noConflict();
jQuery(document).ready(function(){

    var aderezos = new Array();

    $("#agregarAderezos").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        $("input[name=aderezo]:checked").each(function(){

            aderezos.push($(this).attr('data-id'));

        });

        Swal.fire({

            title: 'Agregando Aderezos',
            html: 'Un momento por favor: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft();

                }, 100);

                $.ajax({

                    type: 'POST',
                    url: '/platillo/aderezos',
                    data:{

                        'id' : $("#idPlatilloAderezo").val(),
                        'aderezos' : aderezos,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Aderezos Agregados',
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

            },
            willClose: ()=>{

                clearInterval(procesamiento);

            }

        }).then(function(resultado){

            if( resultado.dismiss == Swal.DismissReason.timer ){

                Swal.fire({

                    icon: 'warning',
                    title: 'Hubo un inconveniente. Trata de nuevo.',
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/platillos';

                    }

                });

            }
            
        });

    });

    $(".aderezos").on('click', function( e ){

        e.preventDefault();

        var id = $(this).attr('data-id');
        var nombre = $(this).attr('data-value');

        if( id === 0 || id === '' || id === null || id === undefined ){

            Swal.fire({

                icon: 'error',
                title: 'Error de lectura',
                allowOutsideClick: false,
                showConfirmButton: true,

            });

            $("#agregarAderezos").attr('disabled', true);

        }else{

            $("#platilloAderezos").val( nombre );
            $("#idPlatilloAderezo").val( id );

            $("#agregarAderezos").attr('disabled', false);

        }

    });

});