jQuery(document).ready(function(){

    $("input[name=bebida]").on('click', function(){

        console.log( $(this).attr('data-id') );

    });

});
