function toggleJarDropDown()
{
    $('#jarDropDownContent').toggle();
    if ($('#jarDropDownContent').is(":visible"))
        $('#jarDropDownFilter').focus();
    return false;
}

function filterJarDropDown(ev)
{
    var code = ev.charCode || ev.keyCode;
    if (code == 27)
        $('#jarDropDownFilter').val('');

    var search = $('#jarDropDownFilter').val().toLowerCase();

    $('#jarDropDownContent span').each(function() {
        $(this).toggle(!search.length);
    });

    $('#jarDropDownContent a').each(function() {
        if (!search.length || $(this).text().toLowerCase().indexOf(search) != -1)
            $(this).show();
        else
            $(this).hide();
    });
}

function selectJar(link)
{
    $('#jarDropDownButton').text($(link).text());
    $('#jar-select').val($(link).attr('data-jar'));
    $('#jarDropDownContent').hide();
    $('#jar-select').trigger('change');
    return false;
}

$(document).click(function(event) {
    var target = $(event.target);
    if (!target.closest('#jarDropDown').length && $('#jarDropDownContent').is(":visible"))
        $('#jarDropDownContent').hide();
});
