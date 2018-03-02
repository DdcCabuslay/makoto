function createDialogHandlers() {
	var doc = document.documentElement;
	var dialogArea = document.getElementsByClassName("dialog_area");
	var pricingButton = document.getElementById("pricing_button");
	var pricingDialog = document.getElementById("pricing_dialog");
	var pricingDialogCloseButton = document.getElementById("close_pricing_dialog");

	pricingButton.addEventListener('click', function() {
		dialogArea[0].style.top = window.scrollY + "px";
		pricingDialog.classList.add("dialog_area_open");
		doc.classList.add("no_scroll");
	});

	pricingDialogCloseButton.addEventListener('click', function() {
		pricingDialog.classList.add("dialog_area_close");
		doc.classList.remove("no_scroll");
		setTimeout(function() {
			pricingDialog.classList.remove("dialog_area_close");
			pricingDialog.classList.remove("dialog_area_open");
		}, 250);
	});
}