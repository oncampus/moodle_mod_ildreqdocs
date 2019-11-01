$(document).ready(function () {
    var reqdoc_form = $(".activity.ildreqdocs.modtype_ildreqdocs .togglecompletion");

    reqdoc_form.each(function () {
        var completionstate = $(this).find("input[name='completionstate']").val();

        if (completionstate == 0) {
            $(this).css('pointer-events', 'none');
        }
    });

    reqdoc_form.click(function (event) {
        var completionstate = $(this).find("input[name='completionstate']").val();

        if (completionstate == 0) {
            event.preventDefault();
        } else {
            $(this).css('pointer-events', 'none');
        }
    });
});