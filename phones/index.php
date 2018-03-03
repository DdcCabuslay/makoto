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
	<?php include 'header.php' ?>
	<main>
		<section class="hero">
			<h1>Phones</h1>
			<img src="../images/phones/home/pixels.png">
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
			<div class="item_grid">
			<?php include 'results.php' ?>
			</div>
		</section>
	</main>
</body>
</html>