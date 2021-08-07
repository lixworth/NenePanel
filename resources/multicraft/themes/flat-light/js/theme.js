function addFooterClass() {
	$('<footer>').addClass('main-footer');
}

function navHeaderHeight() {
	var portletDecoration = $('.portlet-decoration');
	portletDecoration.height(portletDecoration.outerHeight() + 3);
}

function toggleNavbarMenu() {
	$('#navbar-menu, #user-menu').toggleClass('show');
}

$(function() {
	// Event listener for all hints
	$('.hint').hover(function() {
		$('<div class="hintText"></div>')
			.css({top: $(this).position().top - 5, left: $(this).position().left -235})
			.text($(this).data('content'))
			.appendTo($(".hintRow"))
			.slideDown('fast');
	}, function() {
		$('.hintText').remove();
	});

	// Add event listener for the top-menu toggler
	$('#topmenu-toggle .nav-link').click(function() {
		toggleNavbarMenu();
	});

	// Call previously defined functions that need to be invoked on document load
	navHeaderHeight();
	addFooterClass();
});
