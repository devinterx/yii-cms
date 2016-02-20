;(function ($, window, undefined) {
	'use strict';

	var _option = {
		lang: $('html').attr('loc')
	};

	var Modernizr = window.Modernizr;

	$(document).i18n({ language: _option.lang });

	// Hide address bar on mobile devices
	if (Modernizr.touch) {
		$(window).load(function () {
			setTimeout(function () {
				window.scrollTo(0, 1);
			}, 0);
		});
	}
})(jQuery, this);
