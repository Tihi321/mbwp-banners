/* Vanilla JS function */

var banners_global = {
	"top_banner": {
		"parent_ID": "mbwp_top_element_wrapper",
		"cache": getCache("mbwp_top_element_wrapper")
	},
	"left_banner": {
		"parent_ID": "mbwp_left_element_wrapper",
		"cache": getCache("mbwp_left_element_wrapper")
	},
	"right_banner": {
		"parent_ID": "mbwp_right_element_wrapper",
		"cache": getCache("mbwp_right_element_wrapper")
	}
};

banners_global.top_banner.banner_id = getBanner(banners_global.top_banner.parent_ID, banners_global.top_banner.cache);
banners_global.left_banner.banner_id = getBanner(banners_global.left_banner.parent_ID, banners_global.left_banner.cache);
banners_global.right_banner.banner_id = getBanner(banners_global.right_banner.parent_ID, banners_global.right_banner.cache);

function getCache(element_id){

	var element = document.getElementById(element_id);

	if(element == null) return null;

	return element.hasAttribute("wp-cache");

}



function iframeResize(element_id) {

	var element = document.getElementById(element_id);

	if (element == undefined || element == null) {
		return;
	}
	var iframe = element.getElementsByClassName('mbwp-iframe')[0];
	if (iframe == undefined || iframe == null) {
		return;
	}

	var width = iframe.clientWidth;
	iframe.style.height = (width * 0.258) + "px";

	if (element.classList.contains('not-responsive') && width < 965) {
		var backup_image = element.getElementsByClassName("banner-backup-image")[0];
		backup_image.classList.remove("hidden");
		iframe.style.visibility = "hidden";
		return;
	}
}

function adBlockerDetectCheck(element_id, time, object_check) {

	if (element_id.banner_id == null) return;

	object_check = typeof object_check !== 'undefined' ? object_check : false;
	var element = null;

	if (object_check) {
		element = document.getElementById(element_id.banner_id);
	} else {
		element = document.getElementById(element_id);
	}


	if (element == null) {
		return;
	}

	if (element.querySelector('.banner-backup-image') == null) {
		return;
	}

	var iframe = element.getElementsByClassName('mbwp-iframe')[0];
	if (iframe == null) {
		return;
	}

	
	setTimeout(function () {
		adBlockerDetect(iframe, element);
	}, time);

}

function adBlockerDetect(iframe, element) {

	var innerIframe = iframe.contentDocument || iframe.contentWindow.document;
	var ad = innerIframe.getElementsByTagName("BODY")[0];
	var ad_opacity = ad.style.opacity;

	if (ad_opacity == 0 && ad_opacity != "") {
		var backup_image = element.getElementsByClassName("banner-backup-image")[0];
		backup_image.classList.remove("hidden");
		iframe.style.visibility = "hidden";
		return;
	}
}




function init() {
	var vidDefer = document.getElementsByClassName('mbwp-iframe');
	for (var i = 0; i < vidDefer.length; i++) {
		if (vidDefer[i].getAttribute('data-src')) {

			vidDefer[i].setAttribute('src', vidDefer[i].getAttribute('data-src'));

		}
	}


	adBlockerDetectCheck(banners_global.top_banner, '4000', true);
	adBlockerDetectCheck(banners_global.left_banner, '4000', true);
	adBlockerDetectCheck(banners_global.right_banner, '4000', true);
	iframeResize(banners_global.top_banner.banner_id);
}

window.onload = init;

window.addEventListener('resize', function (event) {
	iframeResize(banners_global.top_banner.banner_id);
});



function getBanner(banner_id, cache) {

	var banner = document.getElementById(banner_id);

	if (banner == null) {
		return null;
	}

	if (!banner.hasChildNodes()) {
		return banner_id;
	}

	var elements = banner.getElementsByClassName("mbwp-inner-elements");

	if (cache && elements.length >= 1) {
		if (elements == null) {
			return;
		}
		if (elements.length > 1) {

			var element = getPriorityBasedBanner(elements);
			for (var i = 0; i < elements.length; i++) {

				if (element != elements[i]) {
					elements[i].style.display = "none";
				}
			}
			element.classList.remove("hidden-element");
			return element.id;

		} else {
			elements[0].classList.remove("hidden-element");
			return elements[0].id;
		}
	} else {
		return banner.getElementsByClassName("mbwp-inner-elements")[0].id;
	}
}

function getPriorityBasedBanner(elements) {

	var koeficijent_suma = 0;
	var koeficijent_check = 0;
	var koeficijent = [];

	for (var i = 0; i < elements.length; i++) {
		koeficijent[i] = 1;

		if (elements[i].dataset.priority > 1) {
			koeficijent[i] += parseInt(elements[i].dataset.priority);
		}
		koeficijent_suma += koeficijent[i];
	}

	var random_banner_number = Math.floor((Math.random() * koeficijent_suma) + 1);

	for (var j = 0; j < elements.length; j++) {
		koeficijent_check += 1;

		if (elements[j].dataset.priority > 1) {
			koeficijent_check += parseInt(elements[j].dataset.priority);
		}

		if (random_banner_number <= koeficijent_check) {
			return elements[j];
		}
	}
}