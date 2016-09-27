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
	
	$('.cancel-review-date').click( function( event ) {
		reviewtimestampdiv.slideUp('fast').siblings('a.edit-review-date').show().focus();
		$('#mm').val($('#hidden_mm').val());
		$('#jj').val($('#hidden_jj').val());
		$('#aa').val($('#hidden_aa').val());
		$('#hh').val($('#hidden_hh').val());
		$('#mn').val($('#hidden_mn').val());
		updateReviewText();
		event.preventDefault();
	});
	
	$('.save-review-date').click( function( event ) { 
		if (updateReviewText() ) {
			reviewtimestampdiv.slideUp('fast');
			reviewtimestampdiv.siblings('a.edit-review-date').show().focus();
		}
		event.preventDefault();
	});
	
	function updateReviewText() {
		
		return true;	
	}
		
}(jQuery));