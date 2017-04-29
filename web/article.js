window.onload = function(){
    var errorBlock = document.querySelector('#error-block');
    var successBlock = document.querySelector('#success-block');
    document.forms['article-form'].onsubmit = function(){
        successBlock.innerHTML = '';
        errorBlock.innerHTML = '';
        var params = 'Titre='+this.elements['title'].value;
        params += '&Commentaire='+this.elements['commentary'].value;
        params += '&Image='+this.elements['uploads_file'].value != '';
        console.log(params);

        var errorMessage = '';

        var http = new XMLHttpRequest();
        http.open("POST", "?action=article", true);
        var url = "?action=article";
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onload = function() {
            if(http.readyState == 4 && http.status == 200) {
                successBlock.innerHTML = 'Lol';
            } else{
                var errors = JSON.parse(http.responseText);
                for(var error in errors['errors']){
                    errorBlock.innerHTML += error+' : '+errors['errors'][error]+'<br>';
                }
            }

        };
        http.send(params);
        return false;
    };
};