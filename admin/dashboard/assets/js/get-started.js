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
	var stepsWrap = document.getElementById('lsdp-gs-steps');
	var videoIframe = document.getElementById('lsdp-gs-video-iframe');
	var backBtn = document.getElementById('lsdp-gs-back-btn');
	var cards = wrap.querySelectorAll('.lsdp-gs-builder-card');
	var defaultBuilder = wrap.getAttribute('data-default-builder') || 'gutenberg';
	var preferredBuilder = config.preferredBuilder || defaultBuilder;
	var restoreContent = !!config.restoreContent;
	var hasPicker = !wrap.classList.contains('lsdp-gs-no-picker') && cards.length > 0;

	function escapeHtml(text) {
		var el = document.createElement('div');
		el.appendChild(document.createTextNode(text));
		return el.innerHTML;
	}

	function renderOverview(builder) {
		var items = (builder.overviewItems || []).map(function (item) {
			return '<li><span class="lsdp-gs-check" aria-hidden="true"></span><span>' + escapeHtml(item) + '</span></li>';
		}).join('');

		stepsWrap.innerHTML =
			'<h3 class="lsdp-gs-overview-title">' + escapeHtml(builder.overviewTitle || '') + '</h3>' +
			'<ul class="lsdp-gs-overview-list">' + items + '</ul>';
	}

	function renderBuilder(key) {
		var builder = data[key];
		if (!builder) {
			return;
		}

		guideTitle.textContent = builder.guideTitle;
		guideSub.textContent = builder.guideSub;
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
				config.restoreContent = true;
				preferredBuilder = key;
				restoreContent = true;
			}
		}).catch(function () {
			// Preference save is best-effort; UI already updated.
		});
	}

	function selectBuilder(key, activateContent, persist) {
		cards.forEach(function (card) {
			card.classList.toggle('is-selected', card.getAttribute('data-builder') === key);
		});
		renderBuilder(key);
		if (activateContent) {
			wrap.classList.add('is-content-active');
		}
		if (persist) {
			savePreferredBuilder(key);
		}
	}

	function initScreen() {
		if (!hasPicker) {
			renderBuilder(defaultBuilder);
			wrap.classList.add('is-content-active');
			return;
		}

		var builder = preferredBuilder || defaultBuilder;
		if (restoreContent) {
			selectBuilder(builder, true, false);
			return;
		}

		wrap.classList.remove('is-content-active');
		selectBuilder(builder, false, false);
	}

	cards.forEach(function (card) {
		card.addEventListener('click', function () {
			selectBuilder(card.getAttribute('data-builder'), true, true);
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	});

	if (backBtn) {
		backBtn.addEventListener('click', function () {
			wrap.classList.remove('is-content-active');
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	}

	initScreen();
	window.addEventListener('pageshow', initScreen);
})();
