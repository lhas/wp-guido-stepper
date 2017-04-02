(function( $ ) {
	'use strict';

	$(document).ready(function() {

		$('.guido-stepper-container').each(function() {
			var guidoStepper = $(this).find('.guido-stepper');
			var values = [];

			$(guidoStepper).slick({
				infinite: false,
				arrows: false,
				swipe: false,
			});

			$(guidoStepper).find('.guido-stepper-slide-item').on('click', function() {
				var headline = $(this).data('headline');
				var value = $(this).data('value');

				values.push({
					headline: headline,
					value: value,
				});

				$(guidoStepper).slick('slickNext');
				return false;
			});

			$(guidoStepper).find('.guido-stepper-form').on('submit', function() {
				var data = {
					action: 'stepper_submit',
					slide: $(this).data('slide'),
					values: values,
					form: $(this).serializeArray()
				};

				$(this).hide();
				$(guidoStepper).find('.gs-loading').show();
				$.post(ajax_object.ajax_url, data, function(response) {
					$(guidoStepper).find('.gs-loading').hide();
					$(guidoStepper).find('.guido-stepper-form').show();
					$(guidoStepper).slick('slickNext');
				});
				return false;
			});

		});


	});

})( jQuery );
