/**
 * Get Started tab – builder picker and guide switcher.
 */
(function () {
	'use strict';

	var wrap = document.getElementById('lsdp-gs-wrap');
	if (!wrap || !window.lsdpGetStarted) {
		return;
	}

	var config = window.lsdpGetStarted;
	var data = config.builders;
	var guideTitle = document.getElementById('lsdp-gs-guide-title');
	var guideSub = document.getElementById('lsdp-gs-guide-sub');
	var elementorNotice = document.getElementById('lsdp-gs-elementor-notice');
	var stepsWrap = document.getElementById('lsdp-gs-steps');
	var videoIframe = document.getElementById('lsdp-gs-video-iframe');
	var cards = wrap.querySelectorAll('.lsdp-gs-builder-card');
	var defaultBuilder = wrap.getAttribute('data-default-builder') || 'gutenberg';
	var preferredBuilder = config.preferredBuilder || defaultBuilder;
	var isMobileViewport = window.matchMedia && window.matchMedia('(max-width: 560px)').matches;
	var contentChosen = (!isMobileViewport && !!config.restoreContent) || wrap.classList.contains('lsdp-gs-no-picker');

	function escapeHtml(text) {
		var el = document.createElement('div');
		el.appendChild(document.createTextNode(text));
		return el.innerHTML;
	}

	function renderOverview(builder) {
		var items = (builder.overviewItems || []).map(function (item, index) {
			return '<div class="lsdp-gs-step"><span class="lsdp-gs-step-number" aria-hidden="true">' + (index + 1) + '</span><p>' + escapeHtml(item) + '</p></div>';
		}).join('');

		stepsWrap.innerHTML =
			'<h3>' + escapeHtml(builder.overviewTitle || '') + '</h3>' + items;
	}

	function renderBuilder(key) {
		var builder = data[key];
		if (!builder) {
			return;
		}

		guideTitle.textContent = builder.guideTitle;
		guideSub.textContent = builder.guideSub;

		if (elementorNotice) {
			elementorNotice.hidden = key !== 'elementor';
		}

		renderOverview(builder);

		if (videoIframe && builder.embedUrl) {
			videoIframe.src = builder.embedUrl;
		}
	}

	function savePreferredBuilder(key) {
		if (!config.ajaxUrl || !config.nonce) {
			return;
		}

		var body = new window.FormData();
		body.append('action', 'lsdp_save_preferred_builder');
		body.append('nonce', config.nonce);
		body.append('builder', key);

		window.fetch(config.ajaxUrl, {
			method: 'POST',
			body: body,
			credentials: 'same-origin'
		}).then(function (response) {
			return response.json();
		}).then(function (result) {
			if (result && result.success) {
				config.preferredBuilder = key;
				preferredBuilder = key;
			}
		}).catch(function () {
			// Preference save is best-effort; UI already updated.
		});
	}

	function selectBuilder(key, persist) {
		cards.forEach(function (card) {
			var isSelected = card.getAttribute('data-builder') === key;
			card.classList.toggle('is-selected', isSelected);
			card.setAttribute('aria-checked', isSelected ? 'true' : 'false');
		});
		renderBuilder(key);
		if (persist) {
			contentChosen = true;
			wrap.classList.add('is-content-active');
			savePreferredBuilder(key);
		}
	}

	function initScreen() {
		var builder = preferredBuilder || defaultBuilder;
		selectBuilder(builder, false);
		wrap.classList.toggle('is-content-active', contentChosen);
	}

	cards.forEach(function (card) {
		card.addEventListener('click', function () {
			selectBuilder(card.getAttribute('data-builder'), true);
		});
	});

	initScreen();
	window.addEventListener('pageshow', initScreen);
})();
