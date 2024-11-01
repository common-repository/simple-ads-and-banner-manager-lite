jQuery(function($){
	$('.minicolors').minicolors();

	// reset
	$('#reset_options').click(function(){
		if (confirm('Are you sure want to reset the style editor options?')) {
		    var data = {
				action: 'reset_style_editor'
			}

			$.post(ajaxurl, data, function(response){
				window.location.reload();
			})
		} else {
		    // Do nothing!
		}
	});

	// Premium notification
	$('.premium-features').on('click',function(e){
		$('#spb-premium-notification').dialog('open');
		e.stopPropagation();
	});	

	$('#spb-premium-notification').dialog({
		autoOpen: false,
		resizable: false,
	    width: 420,
	    modal: true
	});
})