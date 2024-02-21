jQuery.noConflict();
jQuery(document).ready(function(){

    $("#nuevo").on('click', function(e){

        $.ajax({

            type: 'POST',
            url: '/corte/calcular',
            data:{

                'idCaja' : $("#idCaja").val()

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#total").val( respuesta.total );
                $("#nombre").val( 'Corte' + respuesta.total );

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/cortes/' + $("#idCaja").val();

                    }

                });

            }

        });

    });
    
});