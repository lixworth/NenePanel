$(document).ready(function() {
    $('.hint').hover(function() {
        $('<div class="hintText"></div>')
            .css({top: $(this).position().top - 15, left: $(this).position().left + 20})
            .text($(this).data('content'))
            .appendTo($(".hintRow"))
            .slideDown('fast');
    }, function() {
        $('.hintText').remove();
    });
});
