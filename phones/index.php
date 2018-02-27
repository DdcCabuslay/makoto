<!DOCTYPE html>
<html>
<head>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../styles/style.css">
	<link rel="stylesheet" type="text/css" href="../styles/grid.css">
	<link rel="stylesheet" type="text/css" href="../styles/theme.css">
	<link rel="stylesheet" type="text/css" href="../styles/phones.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Phones - Makoto</title>
</head>
<body>
	<header class="site_header">
		<section>
			<a href="../" class="header_logo">Makoto</a>
			<nav class="site_nav">
				<a class="nav_selected" href=".">
					<i class="fas fa-mobile fa-fw"></i>
					<span class="nav_title">Phones</span>
				</a>
				<a href="../laptops">
					<i class="fas fa-laptop fa-fw"></i>
					<span class="nav_title">Laptops</span>
				</a>
			</nav>
		</section>
		<section>
			<form class="search_form">
				<input placeholder="Search Makoto">
				<button class="search_button">
					<i class="fas fa-search fa-fw"></i>
				</button>
			</form>
		</section>
	</header>
	<main>
		<section class="hero">
			<h1>Phones</h1>
			<img class="hero_img_lower_right" src="../images/phones/home/0.png">
		</section>
		<section id="phones">
			<div class="item_grid_header">
				<section>
					<button>Filter</button>
				</section>
				<section>
					<!-- <button>Compare</button> -->
					<button>Sort</button>
				</section>
			</div>
			<?php include 'results.php' ?>
			<!-- <div class="item_grid">
				<a href="phone.php" class="item">
					<img class="item_img" src="../images/phones/0/0.png">
					<div class="item_info">
						<div class="item_name">Pixel 2 XL</div>
						<span class="item_oem">Google</span>
						<span class="item_primary_price">$899</span>
					</div>
				</a>
				<div class="item">
					<img class="item_img" src="../images/phones/1/0.png">
					<div class="item_info">
						<a class="item_name">5T</a>
						<span class="item_oem">OnePlus</span>
						<span class="item_primary_price">$659</span>
					</div>
				</div>
				<div class="item">
					<img class="item_img" src="../images/phones/2/0.png">
					<div class="item_info">
						<a class="item_name">iPhone X</a>
						<span class="item_oem">Apple</span>
						<span class="item_primary_price">$1319</span>
					</div>
				</div>
				<div class="item">
					<img class="item_img" src="../images/phones/3/0.png">
					<div class="item_info">
						<a class="item_name">Galaxy S8</a>
						<span class="item_oem">Samsung</span>
						<span class="item_primary_price">$1035</span>
					</div>
				</div>
			</div> -->
		</section>
	</main>
</body>
</html>