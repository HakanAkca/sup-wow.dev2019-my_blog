window.onload = function(){

    var errorBlock = document.querySelector('#error-block');
    var successBlock = document.querySelector('#success-block');
    document.forms['password-form'].onsubmit = function(){
        successBlock.innerHTML = '';
        errorBlock.innerHTML = '';
        var params = 'currentPassword='+this.elements['currentPassword'].value;
        params += '&newPassword='+this.elements['newPassword'].value;
        params += '&confirmPassword='+this.elements['confirmPassword'].value;

        var errorMessage = '';

        var http = new XMLHttpRequest();
        http.open("POST", "?action=edit", true);
        var url = "?action=edit";
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onload = function() {
            if(http.readyState == 4 && http.status == 200) {
                successBlock.innerHTML = 'OK BIENVENUE';
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