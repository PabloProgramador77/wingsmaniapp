jQuery.noConflict();
jQuery(document).ready(function(){

    $(".cancelar").on('click', function(e){

        e.preventDefault();

        Swal.fire({

            icon: 'warning',
            title: 'Si deseas cancelar tu pedido por favor llama al restaurante',
            html: 'Tel. 4778056287',
            allowOutsideClick: false,
            showConfirmButton: true,

        });

    });

});