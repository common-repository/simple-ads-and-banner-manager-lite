var initAce;
var timeoutNotice = false;

(function($){

	/**
	 * Ace editor
	 */
	initAce = function(el)
	{
		var textarea = $(el);
	    var mode = textarea.data('editor');
	    var editDiv = $('<div>', {
	      	position: 'absolute',
	      	height: 250,
	      	'class': textarea.attr('class')
	    }).insertBefore(textarea);

	    textarea.css('display','none');
	    var editor = ace.edit(editDiv[0]);
	    editor.getSession().setValue(textarea.val());		    
    	editor.getSession().setMode("ace/mode/css");
    	editor.getSession().setMode("ace/mode/html");
    	editor.setTheme("ace/theme/monokai");

	    // copy back to textarea on form submit...
	    textarea.closest('form').submit(function() {
	      	textarea.val(editor.getSession().getValue());
	    });

	    return editor;
	}

	$(document).ready(function(){
		$('.multiselect').selectize({
		    plugins: ['remove_button'],
		    delimiter: ','
		});

		$('.spb_editor').each(function(){
			initAce(this);
		});
	});

	$('.repeat').each(function() {
        $(this).spb_fields();
    });

    $( document ).delegate('.banner_type', 'change', function () {
	    var elm = $(this);
	    var val = elm.val();
	    // alert(val);

	    changeTypeBanner(elm, val);
	});

	function changeTypeBanner(elm, val){
		var container_desktop = elm.closest('.cont_banner_type').siblings('.content-desktop-group').find('.cont_banner_content .container_content');
		var container_mobile = elm.closest('.cont_banner_type').siblings('.content-mobile-group').find('.cont_banner_content .container_content');
		var key = container_desktop.attr('data-key');

		// Desktop
		switch(val) {
		    case 'googleads':
		    	var input = '<textarea id="content_'+key+'" name="spb_opt[banner]['+key+'][banner_content]" rows="10"></textarea>';
		        container_desktop.html(input);
		        break;
		    case 'banner':
		    	var input = '<div class="shortcode_banner">';
		    		input += '<div id="img_banner_'+key+'" class="img_banner" data-key="'+key+'"><span class="spb_text">Click to Add Image</span></div>';
		    		input += '<input type="hidden" id="img_id_'+key+'" name="spb_opt[banner]['+key+'][banner_content][img_id]">'; 
		    		input += '<input type="text" id="link_'+key+'" class="link_banner" name="spb_opt[banner]['+key+'][banner_content][link]" placeholder="Banner Link">';
		    		input += '</div>';
		        container_desktop.html(input);
		        break;
		    case 'shortcode':
		    	var input = 'Shortcode : <input type="text" style="width:inherit;" id="content_'+key+'" name="spb_opt[banner]['+key+'][banner_content]" placeholder="[your_shortcode]">';
		        container_desktop.html(input);
		        break;
		    default:
		    	var input = '<textarea class="new_spb_editor" id="content_'+key+'" name="spb_opt[banner]['+key+'][banner_content]" rows="2"></textarea>';
		    	// todo change name and class
		        container_desktop.html(input);

		        // reinit ace editor
				container_desktop.find('.new_spb_editor').each(function(){
					initAce(this);
				});
		}

		// Mobile
		switch(val) {
		    case 'googleads':
		    	var input = '<textarea id="content_'+key+'" name="spb_opt[banner]['+key+'][banner_mobile_content]" rows="10"></textarea>';
		        container_mobile.html(input);
		        break;
		    case 'banner':
		    	var input = '<div class="shortcode_banner">';
		    		input += '<div id="img_banner_'+key+'" class="img_banner" data-key="'+key+'"><span class="spb_text">Click to Add Image</span></div>';
		    		input += '<input type="hidden" id="img_id_'+key+'" name="spb_opt[banner]['+key+'][banner_mobile_content][img_id]">'; 
		    		input += '<input type="text" id="link_'+key+'" class="link_banner" name="spb_opt[banner]['+key+'][banner_mobile_content][link]" placeholder="Banner Link">';
		    		input += '</div>';
		        container_mobile.html(input);
		        break;
		    case 'shortcode':
		    	var input = 'Shortcode : <input type="text" style="width:inherit;" id="content_'+key+'" name="spb_opt[banner]['+key+'][banner_mobile_content]" placeholder="[your_shortcode]">';
		        container_mobile.html(input);
		        break;
		    default:
		    	var input = '<textarea class="new_spb_editor" id="content_'+key+'" name="spb_opt[banner]['+key+'][banner_mobile_content]" rows="2"></textarea>';
		    	// todo change name and class
		        container_mobile.html(input);

		        // reinit ace editor
				container_mobile.find('.new_spb_editor').each(function(){
					initAce(this);
				});
		}

	}

	$(document).delegate('.img_banner', 'click', function(e){
		e.preventDefault();

		var elem = $(this);
		var id_key = elem.attr('data-key');
		var id_container = $(this).siblings('#img_id_'+id_key);

	    var custom_uploader = wp.media({
	        title: 'Add Image Banner',
	        button: {
	            text: 'Select Banner Image'
	        },
	        multiple: false  // Set this to true to allow multiple files to be selected
	    })
	    .on('select', function() {
	        var attachment = custom_uploader.state().get('selection').first().toJSON();
	        elem.find('.spb_text').hide();
	        elem.css('background-image', 'url('+attachment.url+')');

	        id_container.val(attachment.id);
	        // console.log(attachment);
	    })
	    .open();

	});

	$('#btn-reset-positions').click(function(){

		var question = confirm('Are you sure?');

		if(! question) return;

		$('#reset-loader').html('Processing..');

		var data = {
			action: 'reset_positions'
		}

		$.post(ajaxurl, data, function(response){
			$('#reset-positions-val').val(response);
			$('#reset-loader').html('Done!');
		});
	});

	/**
     * Tabs
     */
    if( $('.nav-tab-wrapper').length > 0 ) {
    	$('.nav-tab-wrapper').each(function(){
    		var id = $(this).attr('id');
    		var el = this;

    		js_tabs(id, el);
    	});        
    }

    $('.cont_expand_btn').toggle(function() {
    	var container = $(this).parent('.row');
    	container.css('height', '100%');

    	$(this).html("MINIMIZE");

    }, function() {
    	var container = $(this).parent('.row');

    	container.height(75);
    	$(this).html("EXPAND");
    });

    // enable mobile check
    $("#spb_setting_dashboard").on('change', '.spb-enable-mobile', function(){

	    if(this.checked) {
	        $(this).parents('.row').find('.spb-mobile-tab').show();
	    }
	    else {	    	
	    	$(this).parents('.row').find('.spb-desktop-tab').trigger('click');
	        $(this).parents('.row').find('.spb-mobile-tab').hide();
	    }
	});

    // Premium notification

	$(document).on('change', '.premium-features-select', function(){
		$('#spb-premium-notification').dialog('open');

		e.stopPropagation();
	})
	
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

})(jQuery);

// functions
function js_tabs(id, el) 
{
	$ = jQuery;

    var group = $('.' + id),
    	navtabs = $(el).children('a'),
        active_tab = '';

    /* Hide all group on start */
    group.hide();
    group.eq(0).fadeIn();
    navtabs.eq(0).addClass('nav-tab-active');
    
    /* Bind tabs clicks */
    navtabs.click(function(e) {

        e.preventDefault();

        /* Remove active class from all tabs */
        navtabs.removeClass('nav-tab-active');

        $(this).addClass('nav-tab-active').blur();

        var selected = $(this).attr('href');

        group.hide();
        $(selected).fadeIn();
    });
}
