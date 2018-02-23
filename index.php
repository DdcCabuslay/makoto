<!DOCTYPE html>
<html>
<head>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700|Noto+Sans:700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/grid.css">
	<link rel="stylesheet" type="text/css" href="styles/theme.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Makoto</title>
</head>
<body>
	<header class="site_header">
		<section>
			<a href="." class="header_logo">Makoto</a>
			<nav class="site_nav">
				<a href="phones">
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
				<input>
				<button class="search_button fa-fw">
					<i class="fas fa-search"></i>
				</button>
			</form>
		</section>
	</header>
	<main>
		<section class="hero">
			<h1>This is a header</h1>
			<div class="hero_blurb">This is a description</div>
		</section>
		<section id="phones" class="content">
			<h2>Phones</h2>
			<div class="item_grid">
				<div class="item">
					<img class="item_img" src="images/phones/0/0.png">
					<div class="item_info">
						<a href="phones/phone.php" class="item_name">Pixel 2 XL</a>
						<span class="item_oem">Google</span>
						<button class="item_price_button stroked_button">Pricing</button>
					</div>
				</div>
				<div class="item">
					<img class="item_img" src="images/phones/1/0.png">
					<div class="item_info">
						<span class="item_name">5T</span>
						<span class="item_oem">OnePlus</span>
						<button class="item_price_button stroked_button">Pricing</button>
					</div>
				</div>
				<div class="item">
					<img class="item_img" src="images/phones/2/0.png">
					<div class="item_info">
						<span class="item_name">iPhone X</span>
						<span class="item_oem">Apple</span>
						<button class="item_price_button stroked_button">Pricing</button>
					</div>
				</div>
				<div class="item">
					<img class="item_img" src="images/phones/3/0.png">
					<div class="item_info">
						<span class="item_name">Galaxy S8</span>
						<span class="item_oem">Samsung</span>
						<button class="item_price_button stroked_button">Pricing</button>
					</div>
				</div>
			</div>
		</section>
	</main>
</body>
</html>