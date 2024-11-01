jQuery(document).ready(function($){

	var timeoutSendUpdate = false;
	var dataSaved = true;
	var demoData = 0;

	var send_update = function(){
		// demoData++;
		dataSaved = false;
		spb_new_positon = [ ];
		spb_new_positon = $.makeArray($(".spb_banner").map(function()
		{
		    return $(this).data("spb-position");
		}));

		spb_new_key_banner = [ ];
		spb_new_key_banner = $.makeArray($(".spb_banner").map(function()
		{
		    return $(this).data("spb-key-banner");
		}));

		if(timeoutSendUpdate){
			// console.log('cleared ' + demoData);
			clearTimeout(timeoutSendUpdate);	
		} 

		timeoutSendUpdate = setTimeout(function(){
			var spb_ajax_data = {
				post_id: spb_banner.post_id,
				data: spb_new_positon,
				key_banner: spb_new_key_banner,
				action: 'spb_move_banner'
			}

			jQuery.post( spb_banner.ajax_url, spb_ajax_data  , function( response ) {
				dataSaved = true;
				// console.log('saved ' + demoData);
			});
		
		},2000);
	}

	// on close window
	window.addEventListener("beforeunload", function(event) {
        if(! dataSaved) {
        	// by the mozilla policy, this message will not show on firefox
            event.returnValue = "The saving progress is on the way, please wait a second..";
        }
	});	

	$('.spb_banner .icon-arrow-up').click(function(){
		var el = $(this).parents('.spb_banner');
		var betweenEl = el.prev();
	  	var new_pos = el.data('spb-position') - 1;

	  	if(! el.prev().hasClass('no-control')) {
	  		cek_banner(new_pos, 'up', betweenEl);

		  	el.insertBefore(betweenEl);
		  	el.data( 'spb-position' , new_pos);

		    send_update();
	  	}
	});

	$('.spb_banner .icon-arrow-down').click(function() {
		var el = $(this).parents('.spb_banner');
		var betweenEl = el.next();
	  	var new_pos = el.data('spb-position') + 1;
      	
      	// exit if top
	  	if(! el.next().hasClass('no-control')) {
	  		cek_banner(new_pos, 'down', betweenEl);

		  	el.insertAfter(betweenEl);
		  	el.data( 'spb-position' , new_pos);

		    send_update();
	  	}
	});

	function cek_banner(position, type, betweenEl) {
		var banner = false;

		$('banner.spb_banner').each(function(){
			var new_position = $(this).data('spb-position');

			if(position == new_position) {
				banner = $(this);
				return false;
			}
		});

		if(banner && banner.length > 0) {
			if(type == 'down') {
				banner.insertBefore(betweenEl);
				banner.data('spb-position', position - 1);
			} 
			else {
				banner.insertAfter(betweenEl);
				banner.data('spb-position', position + 1);
			}
		}
	}
});