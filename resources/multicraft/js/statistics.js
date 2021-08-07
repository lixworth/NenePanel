$(document).ready(function() {

	/**
	 * Function to get LESS vars via the scooper. This nifty solution based off:
	 * http://stackoverflow.com/questions/10362445/passing-less-variable-to-javascript
	 */
	window.multicraft.less = {};
	$.each(document.styleSheets,function(i,sheet) {
		$.each(sheet.cssRules,function(i,rule) {
			var sRule = rule.cssText;
			if (rule.selectorText == "#scooper") {

				parts = rule.style.content.replace('\'', '').split('|');
				for (i in parts) {
					n = parts[i].split(':');
					window.multicraft.less[n[0]] = n[1];
				}
				window.multicraft.less['font-family-sans-serif'] = rule.style['font-family'];

				return true;
			}
		});
	});

    $('.dial').each(function() {
        var data = {};
        var n = $(this).attr('data-append');

        data.inline = false;
        data.thickness = 0.05;
        data.font = window.multicraft.less['font-family-sans-serif'];
        data.fontWeight = window.multicraft.less['headings-font-weight'];
        data.fgColor = window.multicraft.less['brand-primary'];
        data.inputColor = '#666';
        data.bgColor = '#ccc';

        $(this).knob(data);
    });

	/* Updates on the statistics page *****************************************/

	if ($('#player_dial').length) {
		var $dial = $('#player_dial');
		var $players = $('#players');
		var $percent = $('#player_percent');
		var players_total = $dial.attr('data-max');

		setInterval(function() {
			var players = $players.html();
			$dial.val(players).trigger('change');
			$percent.html(Math.round(players / players_total * 100).toString());
		}, 5000);
	}

});
