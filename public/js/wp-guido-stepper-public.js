(function( $ ) {
	'use strict';

	$(document).ready(function() {
	 $('.guido-stepper').slick({
		 infinite: false,
		 arrows: false,
		 swipe: false,
	 });

	 $('.guido-stepper-slide-item').on('click', function() {
		$('.guido-stepper').slick('slickNext');
		return false;
	 });

	 $('.guido-stepper-submit-button').on('click', function() {
		$('.guido-stepper').slick('slickNext');
		return false;
	 });
	});

})( jQuery );
