/**
 * Automatically Open Subtasks in Asana
 *
 * Note, if you use WebCatalog, just add this to the JS code
 * injection, it works.
 *
 * @since Tuesday, June 21, 2022
 * @see   https://forum.asana.com/t/allow-to-load-all-sub-tasks-at-once/43620/12 Source
 */

// ==UserScript==
// @name         Auto-click "Load More Subtasks"
// @version      1
// @description  Automatically clicks the "Load More Subtasks" link in Asana when present.  Runs for 10 seconds, checking every second.
// @author       Aron Beal
// @match        https://app.asana.com/*
// @grant        none
(function () {
	var count = 10;
	var ival = window.setInterval(() => {
		count--;
		if(count <= 0){
			window.clearInterval(ival);
		}
		let links = document.querySelectorAll('.SubtaskGrid-loadMore');
		if(links.length === 0){
			return;
		}
		Array.from(links).map((link) => {
			link.click();
		});
	}, 1000);
})();
// ==/UserScript==