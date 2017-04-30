window.onload = function(){

    var errorBlock = document.querySelector('#error-block');
    var successBlock = document.querySelector('#success-block');
    document.forms['login-form'].onsubmit = function(){
        successBlock.innerHTML = '';
        errorBlock.innerHTML = '';
        var params = 'username='+this.elements['username'].value;
        params += '&password='+this.elements['password'].value;

        var errorMessage = '';

        var http = new XMLHttpRequest();
        http.open("POST", "?action=login", true);
        var url = "?action=login";
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onload = function() {
            if(http.readyState == 4 && http.status == 200) {
                window.location = 'http:/sup-wow.dev2019-my_blog/?action=home';
            } else {
                var errors = JSON.parse(http.responseText);
                $('#badlog').text('Mauvais Mdp ou Login');
            }
        };
        http.send(params);
        return false;
    };
};