jQuery(function() {
    $(".hide").hide();
    $(".lienvisible").click(function() {
        // on recupere le lien dans le DOM
        var $link = $(this);

        // on recupere la balise hide suivant le lien dans le DOM
        var $hide = $link.next('.hide');

        // on remonte toutes les balises hide
        $('.hide').show();
    });
});