
window.onload = function(){
    var errorBlock = document.getElementById('errorBlock');
    var successBlock = document.getElementById('successBlock');

    document.forms['change-form'].onsubmit = function(){
        errorBlock.innerHTML = '';
        successBlock.innerHTML = '';
        var formValid = true;
        var email = this.elements['change-email'].value;
        var prenom = this.elements['change-prenom'].value;
        var nom = this.elements['change-nom'].value;
        var ville = this.elements['change-ville'].value;

        var emailRegExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(emailRegExp.test(email) === false){
            formValid = false;
            errorBlock.innerHTML = '<br>veuillez saisir une adresse email valide';
        }

        if(prenom.length < 4){
            formValid = false;
            errorBlock.innerHTML = '<br>Champ vide merci de saissir un prenom';
        }

        if(nom.length < 4){
            formValid = false;
            errorBlock.innerHTML = '<br>Champ vide merci de saissir un nom';
        }

        if(ville.length < 4){
            formValid = false;
            errorBlock.innerHTML = '<br>Champ vide merci de saissir une ville';
        }

        if(formValid === true) {
            var resultString = 'Form OK ! Vous avez choisi la sauce ';
            resultString += '<br> Vos données on était mis a jours ';
            successBlock.innerHTML = resultString;
        }
        return false;
    };
};
