$(document).ready(function()
{
    $(".hide").hide();
    $( ".lienvisible" ).on( "click", function()
    {
        var jObj = $( this ).nextAll( '.hide' ).eq( 0 );


        $( ".hide" ).not( jObj ).slideUp( "slow" );
        jObj.slideToggle( 'slow' );
    });
});