$(document).ready(function () {
    var i = 0;

    $("#persist-box").change(function () {
        if ($(this).is(":checked")) {
            var returnVal = confirm("You will now be automatically added to future lunches. Your presence is your responsibility!");
            $(this).attr("checked", returnVal);
        }
        $('#textbox1').val($(this).is(':checked'));
    })
    $(".secret_button").click(function () {
        i++;
        if (i > 2) {
            $("#delete_button").removeClass("hidden");
        }
    })

    $('div.alert').not('.alert-important').delay(3000).slideUp(350);
    
});