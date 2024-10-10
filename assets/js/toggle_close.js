
//TOGLE SHOW HIDE
$('.nav-toggle-alt').click(function() {
	//get collapse content selector
	var collapse_content_selector = $(this).attr('href');

	//make the collapse content to be shown or hide
	var toggle_switch = $(this);
	$(collapse_content_selector).slideToggle(function() {
			if ($(this).css('display') == 'block') {
					//change the button label to be 'Show'
					toggle_switch.html('<div>Hide Map <span class="entypo-up-open"></span></div>');
			} else {
					//change the button label to be 'Hide'
					toggle_switch.html('<div>Open Map <span class="entypo-down-open"></span></div>');
			}
	});
	return false;
});
//CLOSE ELEMENT
	$(".gone").click(function() {
	var collapse_content_close = $(this).attr('href');
	$(collapse_content_close).hide();



});