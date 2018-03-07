<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<link rel="stylesheet" href="https://use.typekit.net/ypw0bea.css">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/grid.css">
	<link rel="stylesheet" type="text/css" href="styles/theme.css">
	<link rel="stylesheet" type="text/css" href="styles/home.css">
	<title>Makoto</title>
</head>
<body>
	<?php include 'header.php' ?>
	<main>
		<div class="hero home_hero_main">
			<h1>Choosing a phone can be hard.</h1>
			<h2>Let's help you find one.</h2>
			<div class="home_hero_button_row">
				<a class="button filled_button" href="phones">Browse Phones</a>
			</div>
		</div>
		<div class="hero home_hero_grid">
			<div class="home_hero" style="background-color: #f4f4f4;">
				<div class="home_hero_info">
					<h2>Google Pixel 2</h2>
					<div>
						<a href="phones/phone.php?id=1" class="button stroked_button">Pixel 2</a>
						<a href="phones/phone.php?id=0" class="button stroked_button">Pixel 2 XL</a>
					</div>
				</div>
				<img src="images/home/pixel2.jpg">
			</div>
			<div class="home_hero" style="background-color: #fceee5;">
				<div class="home_hero_info">
					<h2>Apple iPhone 8</h2>
					<div>
						<a href="phones/phone.php?id=3" class="button stroked_button">iPhone 8</a>
						<a href="phones/phone.php?id=4" class="button stroked_button">iPhone 8 Plus</a>
					</div>
				</div>
				<img src="images/home/iphone8.jpg">
			</div>
			<div class="home_hero" style="background-color: #fff;">
				<div class="home_hero_info">
					<h2>LG V30</h2>
					<div>
						<a href="phones/phone.php?id=10" class="button stroked_button">More Info</a>
					</div>
				</div>
				<img src="images/home/lgv30.jpg">
			</div>
			<div class="home_hero" style="background-color: #2b2b2b;">
				<div class="home_hero_info">
					<h2 style="color: #d8d8d8;">Essential Phone</h2>
					<div>
						<a href="phones/phone.php?id=9" class="button stroked_button" style="color: #d8d8d8; border-color: #d8d8d8;">More Info</a>
					</div>
				</div>
				<img src="images/home/essential.jpg">
			</div>
		</div>
	</main>
</body>
</html>