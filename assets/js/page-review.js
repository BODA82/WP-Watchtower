(function($) {
	
	var reviewtimestampdiv = $('#reviewtimestampdiv');
		
	$('.edit-review-date').click(function(event) {
		console.log('test');
		if (reviewtimestampdiv.is(':hidden')) {
			reviewtimestampdiv.slideDown('fast', function() {
				$('input, select', reviewtimestampdiv.find('.review-date-wrap')).first().focus();
			});
			$(this).hide();
		}
		event.preventDefault();
	});
	
	$('.cancel-review-date').click(function(event) {
		reviewtimestampdiv.slideUp('fast').siblings('a.edit-review-date').show().focus();
		event.preventDefault();
	});
	
	$('.reset-review-date').click(function(event) {
		reviewtimestampdiv.slideUp('fast').siblings('a.edit-review-date').show().focus();
		
		$('#wpw-review-set').val('notset');
		
		event.preventDefault();
	});
	
	$('.save-review-date').click(function(event) {
		reviewtimestampdiv.slideUp('fast').siblings('a.edit-review-date').show().focus();
		
		$('#wpw-review-set').val('set');
		
		event.preventDefault();
	});
		
}(jQuery));