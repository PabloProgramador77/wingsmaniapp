jQuery.noConflict();
jQuery(document).ready(function(){

    $(".confirmar").on('click', function(e){

        e.preventDefault();

        Swal.fire({

            title: 'Enviando a Cocina',
            html: 'Un momento por favor: <b></b>',
            timer: 4975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft();

                }, 100);

            },
            willClose: ()=>{

                clearInterval(procesamiento);

            }

        }).then((resultado)=>{

            if( resultado.dismiss == Swal.DismissReason.timer ){

                window.location.href = '/pedidos';

            }

        });

    });

});