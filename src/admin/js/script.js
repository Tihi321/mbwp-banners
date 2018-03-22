(function ($) {

	window.addEventListener("load", function() {


		// Add Color Picker to all inputs that have 'color-field' class
		$('.cpa-color-picker').wpColorPicker();

		// store tabs variables
		var tabs = document.querySelectorAll("ul.nav-tabs > li");

		for (var i = 0; i < tabs.length; i++) {
			tabs[i].addEventListener("click", switchTab);
		}

		function switchTab(event) {
			event.preventDefault();

			document.querySelector("ul.nav-tabs li.active").classList.remove("active");
			document.querySelector(".tab-pane.active").classList.remove("active");

			var clickedTab = event.currentTarget;
			var anchor = event.target;
			var activePaneID = anchor.getAttribute("href");

			clickedTab.classList.add("active");
			document.querySelector(activePaneID).classList.add("active");

		}

	});

})(jQuery);