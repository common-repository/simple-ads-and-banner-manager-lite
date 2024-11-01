(function($) {
	$.fn.spb_fields = function(custom_settings) {
		var default_settings = {
			wrapper: '.wrapper',
			container: '.container',
			row: '.row',
			add: '.add',
			remove: '.remove',
			move: '.move',
			template: '.template',
		}

		var settings = $.extend(default_settings, custom_settings);

		// Initialize all repeatable field wrappers
		initialize(this);

		function initialize(parent) {
			$(settings.wrapper, parent).each(function(index, element) {
				var wrapper = this;

				var container = $(wrapper).children(settings.container);

				// Disable all form elements inside the row template
				$(container).children(settings.template).hide().find(':input').each(function() {
					$(this).prop('disabled', true);
				});

				var row_count = $(container).children(settings.row).filter(function() {
					return !$(this).hasClass(settings.template.replace('.', ''));
				}).length;

				$(container).attr('data-rf-row-count', row_count);

				$(wrapper).on('click', settings.add, function(event) {
					event.stopImmediatePropagation();

					var row_template = $($(container).children(settings.template).clone().removeClass(settings.template.replace('.', ''))[0].outerHTML);

					// Enable all form elements inside the row template
					$(row_template).find(':input').each(function() {
						$(this).prop('disabled', false);
					});

					var new_row = $(row_template).show().appendTo(container);

					if(typeof settings.after_add === 'function') {
						settings.after_add(container, new_row);
					}

					var row_count = $(container).attr('data-rf-row-count');

					row_count++;

					$('*', new_row).each(function() {
						$.each(this.attributes, function(index, element) {
							this.value = this.value.replace(/{{row-count-placeholder}}/, row_count - 1);
						});
					});

					$(container).attr('data-rf-row-count', row_count);

					// reinit js tab
					$(new_row).find('.nav-tab-wrapper-origin').each(function(){
						var id = $(this).attr('id');
			    		var el = this;

			    		$(this).attr('class', 'nav-tab-wrapper');

			    		js_tabs(id, el);
					});

					initialize(new_row);
				});

				$(wrapper).on('click', settings.remove, function(event) {
					event.stopImmediatePropagation();

					var row = $(this).parents(settings.row).first();

					row.remove();

					$(container).attr('data-rf-row-count', row_count);
				});
			});
		}
	}
})(jQuery);