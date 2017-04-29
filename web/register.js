window.onload = function(){

    var errorBlock = document.querySelector('#error-block');
    var successBlock = document.querySelector('#success-block');
    document.forms['register-form'].onsubmit = function(){
        successBlock.innerHTML = '';
        errorBlock.innerHTML = '';
        var params = 'username='+this.elements['username'].value;
        params += '&email='+this.elements['email'].value;
        params += '&password='+this.elements['password'].value;
        params += '&firstname='+this.elements['firstname'].value;
        params += '&lastname='+this.elements['lastname'].value;
        params += '&city='+this.elements['city'].value;
        var errorMessage = '';

        var http = new XMLHttpRequest();
        http.open("POST", "?action=register", true);
        var url = "?action=register";
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onload = function() {
            if(http.readyState == 4 && http.status == 200) {
                successBlock.innerHTML = 'Inscription réussi vous aller être rediriger';
                window.setTimeout(function(){
                    window.location.href = 'http:/sup-wow.dev2019-my_blog/?action=login'
                }, 5000);
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