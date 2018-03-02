<?php
	// $phone_id = $_GET['id'];
	// $storage = $_GET['storage'];
	$storage = 64;
	$colour_id = 4;
	// $colour_id = $_GET['colour'];

	$priceDbQuery = "select vendor.id, is_carrier, price, phone_pricing.url from makoto.phone_pricing, makoto.vendor where phone_id = $1 and storage = $2 and colour_id = $3 and vendor_id = vendor.id order by price, is_carrier, vendor.id";
	$priceResults = pg_query_params($connection, $priceDbQuery, array($id, $storage, $colour_id));
	$priceArray = array();
	$counter = 0;
	while ($row = pg_fetch_array($priceResults)) {
		$priceArray[$counter]['vendor_id'] = $row['id'];
		$priceArray[$counter]['is_carrier'] = $row['is_carrier'];
		$priceArray[$counter]['price'] = $row['price'];
		$priceArray[$counter]['url'] = $row['url'];
		$counter++;
	}

	$cheapestVendorPriceDbQuery = "select name, price, phone_pricing.url from makoto.phone_pricing, makoto.vendor where phone_id = $1 and storage = $2 and colour_id = $3 and vendor_id = vendor.id and is_carrier = false order by price limit 1";
	$cheapestVendorPriceResult = pg_query_params($connection, $cheapestVendorPriceDbQuery, array($id, $storage, $colour_id));
	$cheapestVendorPrice = pg_fetch_array($cheapestVendorPriceResult);

	$colourDbQuery = "select colour_name from makoto.colours where id = $1";
	$colourResult = pg_query_params($connection, $colourDbQuery, array($colour_id));
	$colour = pg_fetch_array($colourResult);
?>
<aside id="pricing_dialog" class="dialog_area">
	<div class="dialog">
		<section class="dialog_header">
			<h2 class="dialog_title">Pricing for <?= $phoneInfo['oem_name'] . ' ' . $phoneInfo['model'] ?></h2>
			<span class="dialog_subtitle"><?= $colour['colour_name'] . ', ' . $storage?> GB</span>
		</section>
		<section class="dialog_body">
			<h3>Carrier Pricing</h3>
			<?php foreach($priceArray as $price): ?>
			<?php if ($price['is_carrier'] == 't'): ?>
			<div class="dialog_cell">
				<a target="_blank" rel="noopener noreferrer" href="<?= $price['url'] ?>" class="button price_button" style="background-image: url('../images/vendors/<?= $price['vendor_id'] ?>.png')"></a>
				<span class="dialog_price">$<?= $price['price'] ?></span>
			</div>
			<?php endif; ?>
			<?php endforeach; ?>
			<h3>Vendor Pricing</h3>
			<?php foreach($priceArray as $price): ?>
			<?php if ($price['is_carrier'] == 'f'): ?>
			<div class="dialog_cell">
				<a target="_blank" rel="noopener noreferrer" href="<?= $price['url'] ?>" class="button price_button" style="background-image: url('../images/vendors/<?= $price['vendor_id'] ?>.png')"></a>
				<span class="dialog_price">$<?= $price['price'] ?></span>
			</div>
			<?php endif; ?>
			<?php endforeach; ?>
		</section>
		<section class="dialog_footer">
			<button id="close_pricing_dialog">Close</button>
		</section>
	</div>
</aside>