(function($){	
	function get_banner_content(ignore){
		var list=[];
	    var weight=[];

	    var arr_ign = (typeof ignore !== 'undefined' && ignore !== null) ? ignore.split(',') : false;

	    // push to array
	    $('#spbbanner').find('.available-banner').each(function(i, e){
	        var id = $(this).attr('id'),
	        	bannerId = $(this).attr('data-id'),
	            priority = $(this).attr('data-weight');

	        if(arr_ign !== false){
				if (arr_ign.indexOf(bannerId) === -1) {
					// alert(bannerId);
					list.push(id);
	            	weight.push(priority);
				}
			} else {
				list.push(id);
            	weight.push(priority);
			}

	    });

	    var rand = function(min, max) {
	        return Math.floor(Math.random() * (max - min + 1)) + min;
	    };
	     
	    var generateWeighedList = function(list, weight) {
	        var weighed_list = [];
	         
	        // Loop over weights
	        for (var i = 0; i < weight.length; i++) {
	            var multiples = weight[i] * 100;
	             
	            // Loop over the list of items
	            for (var j = 0; j < multiples; j++) {
	                weighed_list.push(list[i]);
	            }
	        }
	         
	        return weighed_list;
	    };

	    var weighed_list = generateWeighedList(list, weight);
	    var random_num = rand(0, weighed_list.length-1);
	    var $el = $('#'+weighed_list[random_num]);

	    return $el;
	}

	var ignore = undefined;
	$('.spb_banner_entry').each(function(i,e){
		var el_banner = get_banner_content(ignore),
			id_banner = el_banner.attr('data-id'),
			content = el_banner.find('.banner_content').html();

		$(this).html(content);

		// update slected banner to ignore list 
		if(typeof(ignore) == 'undefined'){
			ignore = id_banner;
		} else {
			ignore = ignore+','+id_banner;
		}
	});


	// Premium notification
	$('.premium-features').click(function(){
		$('#spb-premium-notification').dialog('open');
	});	

	$('#spb-premium-notification').dialog({
		autoOpen: false,
		resizable: false,
	    width: 420,
	    height: 200,
	    modal: true,
	    dialogClass: "ssliderConfirmDialog"
	});

})(jQuery);