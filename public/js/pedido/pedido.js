jQuery.noConflict();
jQuery(document).ready(function(){

    $("#pedido").on('click', function(e){

        e.preventDefault();

        Swal.fire({

            icon: 'info',
            title: '¿Qué tipo de pedido?',
            html: 'A domicilio o para recoger en restaurante.',
            allowOutsideClick: false,
            confirmButtonText: 'A domicilio',
            denyButtonText: 'Para recoger en restaurante',
            showConfirmButton: true,
            showDenyButton: true,

        }).then((resultado)=>{

            let tipo;

            if( resultado.isConfirmed ){
                tipo = 'delivery';

                $.ajax({

                    type: 'POST',
                    url: '/pedido/agregar',
                    data:{

                        'tipo' : tipo,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Ahora los platillos de tu pedido.',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/pedido/menu';

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

                                window.location.href = '/';

                            }

                        });

                    }

                });

            }else{

                tipo = 'pickup';

                $.ajax({

                    type: 'POST',
                    url: '/pedido/agregar',
                    data:{

                        'tipo' : tipo,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Elige los platillos de tu pedido.',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/pedido/menu';

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

                                window.location.href = '/';

                            }

                        });

                    }

                });

            }

        });

    });

});