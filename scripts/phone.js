function changeSelectedColour() {
	var activeColour = document.querySelectorAll(".colour_button.info_window_row_button_active");
	activeColour[0].classList.remove("info_window_row_button_active");
	this.classList.add("info_window_row_button_active");
	var newColour = this.getAttribute("data-colour-id");

	var productImage = document.getElementsByClassName("product_image");
	var imageThumbs = document.getElementsByClassName("image_thumb");
	var productMedia = document.getElementsByClassName("product_media");

	productImage[0].addEventListener("load", function() {
		productMedia[0].style.opacity = 1;
		productImage[0].style.opacity = 1;
	});

	productMedia[0].style.opacity = 0.2;
	setTimeout(function() {
		for (var i = 0; i < imageThumbs.length; i++) {
			changeImageColour(imageThumbs[i], newColour);
		}	
		changeImageColour(productImage[0], newColour);	
	}, 100);
}

function changeSelectedStorage() {
	var activeStorage = document.querySelectorAll(".storage_button.info_window_row_button_active");
	activeStorage[0].classList.remove("info_window_row_button_active");
	this.classList.add("info_window_row_button_active");
}

function changeImageColour(img, colour) {
	imgSrcArray = img.getAttribute("src").split("/");
	imgSrcArray[4] = colour;
	img.src = imgSrcArray.join("/");
}

function changeFeaturedImage() {
	var productImage = document.getElementsByClassName("product_image");
	productImage[0].src = this.getAttribute("src");
}

function getPricing() {
	var pricingButton = document.getElementById("pricing_button");
	var activeColour = document.querySelectorAll(".colour_button.info_window_row_button_active");
	var activeStorage = document.querySelectorAll(".storage_button.info_window_row_button_active");
	var colour_id = activeColour[0].getAttribute("data-colour-id");
	var storage = activeStorage[0].getAttribute("data-storage");
	var dialog = document.getElementById("pricing_dialog");
	var url = (new URL(window.location.href)).searchParams;
	var id = url.get("id");

	pricingButton.setAttribute("disabled", "");
	var requestUrl = "price_dialog.php?id=" + id + "&colour=" + colour_id + "&storage=" + storage; 
	var request = new Request(requestUrl);	
	fetch(request)
		.then(function(response) {
			return response.text();
		}).then(function(html) {
			dialog.innerHTML = html;
			createDialogHandlers();
			pricingButton.removeAttribute("disabled");
		});
}

function manageSpecTableRow() {
	if (this.classList.contains("spec_table_row_open")) {
		this.classList.add("spec_table_row_close");
		setTimeout(function(element) {
			element.classList.remove("spec_table_row_open", "spec_table_row_close");
		}, 750, this);
	} else {
		this.classList.add("spec_table_row_open");
	}
}

window.onload = function() {
	var colourButtons = document.getElementsByClassName("colour_button");
	var storageButtons = document.getElementsByClassName("storage_button");
	colourButtons[0].classList.add("info_window_row_button_active");
	storageButtons[0].classList.add("info_window_row_button_active");

	for (var i = 0; i < colourButtons.length; i++) {
		colourButtons[i].addEventListener("click", changeSelectedColour);
		colourButtons[i].addEventListener("click", getPricing);
	}
	for (var i = 0; i < storageButtons.length; i++) {
		storageButtons[i].addEventListener("click", changeSelectedStorage);
		storageButtons[i].addEventListener("click", getPricing);
	}

	var productImage = document.getElementsByClassName("product_image");
	var imageThumbs = document.getElementsByClassName("image_thumb");
	var productMedia = document.getElementsByClassName("product_media");

	productImage[0].addEventListener("load", function() {
		productMedia[0].style.opacity = 1;
	});

	for (var i = 0; i < imageThumbs.length; i++) {
		imageThumbs[i].addEventListener("click", changeFeaturedImage);
	}

	var specTableRows = document.getElementsByClassName("spec_table_row");
	for (var i = 0; i < specTableRows.length; i++) {
		specTableRows[i].addEventListener("click", manageSpecTableRow);
	}

	getPricing();
}