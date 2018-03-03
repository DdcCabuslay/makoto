<!DOCTYPE html>
<html>
<head>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/grid.css">
	<link rel="stylesheet" type="text/css" href="styles/theme.css">
	<link rel="stylesheet" type="text/css" href="styles/home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Makoto</title>
</head>
<body>
	<?php include 'header.php' ?>
	<main>
		<div class="hero home_hero_main">
			<h1>Choosing a phone can be hard.</h1>
			<h2>Hopefully I can help.</h2>
			<div class="home_hero_button_row">
				<a class="button filled_button" href="phones">Browse Phones</a>
			</div>
		</div>
		<div class="hero home_hero_grid">
			<div class="home_hero" style="background-color: #000;">
				<div class="home_hero_info">
					<h2 style="color: #fff;">Samsung Galaxy S9</h2>
					<a href="phones/phone.php?id=10" class="button stroked_button" style="color: #fff; border-color: #fff;">More Info</a>
				</div>
				<img src="images/home/s9.jpg">
			</div>
			<div class="home_hero" style="background-color: #f4f4f4;">
				<div class="home_hero_info">
					<h2>Google Pixel 2 XL</h2>
					<a href="phones/phone.php?id=0" class="button stroked_button">More Info</a>
				</div>
				<img src="images/home/0.jpg">
			</div>
			<div class="home_hero" style="background-color: #2b2b2b;">
				<div class="home_hero_info">
					<h2 style="color: #d8d8d8;">Essential Phone</h2>
					<a href="phones/phone.php?id=9" class="button stroked_button" style="color: #d8d8d8; border-color: #d8d8d8;">More Info</a>
				</div>
				<img src="images/home/9.jpg">
			</div>
			<div class="home_hero" style="background-color: #fafafa;">
				<div class="home_hero_info">
					<h2>Apple iPhone X</h2>
					<a href="phones/phone.php?id=2" class="button stroked_button">More Info</a>
				</div>
				<img src="images/home/2.jpg">
			</div>
		</div>
	</main>
</body>
</html>