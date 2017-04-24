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
				var step = $(this).data('step');

				switch(step) {
					case '1st':
						window.localStorage.setItem('form', JSON.stringify($(this).serializeArray()));
						$(guidoStepper).slick('slickNext');
					break;
					case '2nd':
						var form = JSON.parse(window.localStorage.getItem('form'));
						form = form.concat($(this).serializeArray());

						var data = {
							action: 'stepper_submit',
							slide: $(this).data('slide'),
							values: values,
							form: form
						};

						$(this).hide();
						$(guidoStepper).find('.gs-loading').show();
						$.post(ajax_object.ajax_url, data, function(response) {
							$(guidoStepper).find('.gs-loading').hide();
							$(guidoStepper).find('.guido-stepper-form').show();
							$(guidoStepper).slick('slickNext');
						});
					break;
				}
				return false;
			});

		});


	});

})( jQuery );
