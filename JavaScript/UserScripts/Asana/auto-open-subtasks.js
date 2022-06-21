/**
 * Automatically Open Subtasks in Asana
 *
 * Note, if you use WebCatalog, just add this to the JS code
 * injection, it works.
 *
 * Also this version checks for links to click indefinitly, vs how
 * the original only ran for 10 seconds.
 *
 * @since Tuesday, June 21, 2022
 *        - Adjustments to check indefinitly every 2 seconds.
 *
 * @see   https://forum.asana.com/t/allow-to-load-all-sub-tasks-at-once/43620/12 Source
 */

// ==UserScript==
// @name         Auto-click "Load More Subtasks"
// @version      1.1
// @description  Automatically clicks the "Load More Subtasks" link in Asana when present.
// @author       Aron Beal
// @match        https://app.asana.com/*
// @grant        none
(function () {

	window.setInterval(() => {

		let links = document.querySelectorAll('.SubtaskGrid-loadMore');

		if(links.length === 0){
			return;
		}

		Array.from(links).map((link) => {
			link.click();
		});
	}, 2000);
})();
// ==/UserScript==