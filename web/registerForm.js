$(document).ready(function () {


    $('form').submit(function () {
        if ($('#username').val().length < 1) {
            $('#username').css("border-color", "red");
            formValid = false;
        }

        if ($('#email').val() != /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/) {
            $('#email').css("border-color", "red");
            formValid = false;
        }

        if ($('#password').val().length < 1) {
            $('#password').css("border-color", "red");
            formValid = false;
        }

        if ($('#firstname').val().length < 1) {
            $('#firstname').css("border-color", "red");
            formValid = false;
        }

        if ($('#lastname').val().length < 1) {
            $('#lastname').css("border-color", "red");
            formValid = false;
        }

        if ($('#city').val().length < 1) {
            $('#city').css("border-color", "red");
            formValid = false;
        }
    });
});