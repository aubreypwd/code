// ==UserScript==
// @name         Auto-click "Load More Subtasks" in Asana
// @version      1.1
// @description  Automatically clicks the "Load More Subtasks" link in Asana when present.
//               Note, if you are using WebCatalog, just add this to the JS injection panel in the settings.
// @author       Aubrey Portwood; a modified version by Aron Beal
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