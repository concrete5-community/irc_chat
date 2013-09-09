$(document).ready(function(){
	var showPane = function(pane) {
		$('#ircchat-tabheaders li').removeClass('active');
		$('.ircchat-tabpane').hide();
		$('#ircchat-tabheader-' + pane).closest('li').addClass('active');
		$('#ircchat-tabpane-' + pane).show();
	};
	$('#ircchat-tabheaders a').on('click', function() {
		showPane($(this).attr('id').substr('ircchat-tabheader-'.length));
	});
	showPane('irc');
});
