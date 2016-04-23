$(document).ready(function () {
    $("#persist-box").change(function () {
        if ($(this).is(":checked")) {
            var returnVal = confirm("You will now be automatically added to future lunches. Your presence is your responsibility!");
            $(this).attr("checked", returnVal);
        }
        $('#textbox1').val($(this).is(':checked'));
    })
});