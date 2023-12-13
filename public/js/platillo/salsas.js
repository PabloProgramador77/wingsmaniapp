jQuery.noConflict();
jQuery(document).ready(function(){

    var salsas = new Array();

    $("#agregar").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        $("input[name=salsa]:checked").each(function(){

            salsas.push($(this).attr('data-id'));

        });

        Swal.fire({

            title: 'Agregando Salsas',
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
                    url: '/platillo/salsas',
                    data:{

                        'id' : $("#id").val(),
                        'salsas' : salsas,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Salsas Agregadas',
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

});