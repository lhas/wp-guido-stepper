(function( $ ) {
	'use strict';

	$(document).ready(function() {
		$('.guido-stepper').slick({
			infinite: false,
			arrows: false,
			swipe: false,
		});

		var values = [];

		$('.guido-stepper-slide-item').on('click', function() {
			var headline = $(this).data('headline');
			var value = $(this).data('value');

			values.push({
				headline: headline,
				value: value,
			});

			$('.guido-stepper').slick('slickNext');
			return false;
		});

		$('.guido-stepper-form').on('submit', function() {
			console.log(values);
			$('.guido-stepper').slick('slickNext');
			return false;
		});
	});

})( jQuery );
