multicraft = {}; // Globally scoped object for talking to other inline Yii Js

$(document).ready(function() {
	$('[data-focus]').focus();
});

function showSub(name)
{
    $("#"+name+"_main").children(":not(p,span)").toggle();
    $("#"+name).stop(true, true).slideToggle();
}
