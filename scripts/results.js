function getResults() {
	var itemGrid = document.getElementsByClassName("item_grid")[0];

	var requestUrl = "results.php";
	var request = new Request(requestUrl);
	fetch(request)
		.then(function(response) {
			return response.text();
		}).then(function(html) {
			itemGrid.innerHTML = html;
		});
}

window.onload = function() {
	getResults();
}