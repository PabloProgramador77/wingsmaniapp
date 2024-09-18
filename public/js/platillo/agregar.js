jQuery.noConflict();
jQuery(document).ready(function(){

    $("#registrar").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        const formData = new FormData();
        formData.append( 'nombre', $("#nombre").val() );
        formData.append( 'precio', $("#precio").val() );
        formData.append( 'categoria', $("#categoria").val() );
        formData.append( 'descripcion', $("#descripcion").val() );
        formData.append( 'salsas', $("#salsas").val() );

        if( $("#portada")[0].files.length > 0 ){

            formData.append( 'portada', $("#portada")[0].files[0] );

        }

        Swal.fire({

            title: 'Registrando Platillo',
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
                    url: '/platillo/agregar',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Platillo Registrado',
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

        }).then((resultado)=>{

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