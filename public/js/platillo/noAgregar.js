jQuery.noConflict();
jQuery(document).ready(function(){

    $("#nuevo").on('click', function(e){

        e.preventDefault();

        Swal.fire({

            icon: 'warning',
            title: 'Para agregar platillos primero debes agregar categorías.',
            allowOutsideClick: false,
            showConfirmButton: true

        }).then((resultado)=>{

            if( resultado.isConfirmed ){

                window.location.href = '/categorias';

            }

        });

    });

});