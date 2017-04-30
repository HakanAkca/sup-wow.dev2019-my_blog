$(document).ready(function () {


    $('form').submit(function () {
        if ($('#username').val().length < 1) {
            $('#username').css("border-color", "red");
            formValid = false;
        }

        if ($('#password').val().length < 1) {
            $('#password').css("border-color", "red");
            formValid = false;
        }
    });
});
