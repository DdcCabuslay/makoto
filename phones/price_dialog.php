<?php
	$phone_id = $_GET['id'];
	$storage = $_GET['storage'];
	$colour_id = $_GET['colour'];

	$connectString = "dbname=ddccabuslay user=" . $_SERVER['DB_USER'];
	$connection = pg_connect($connectString) or die('Could not connect: ' . pg_last_error());
	$priceDbQuery = "select vendor.id, is_carrier, price, note, phone_pricing.url from makoto.phone_pricing, makoto.vendor where phone_id = $1 and storage = $2 and colour_id = $3 and vendor_id = vendor.id order by price, is_carrier, vendor.id";
	$priceResults = pg_query_params($connection, $priceDbQuery, array($phone_id, $storage, $colour_id));
	$priceArray = array();
	$counter = 0;
	$carrierLinks = 0;
	$vendorLinks = 0;
	while ($row = pg_fetch_array($priceResults)) {
		$priceArray[$counter]['vendor_id'] = $row['id'];
		$priceArray[$counter]['is_carrier'] = $row['is_carrier'];
		$priceArray[$counter]['price'] = $row['price'];
		$priceArray[$counter]['note'] = $row['note'];
		$priceArray[$counter]['url'] = $row['url'];
		if ($row['is_carrier'] == 't') {
			$carrierLinks++;
		} else {
			$vendorLinks++;
		}
		$counter++;
	}

	$colourDbQuery = "select colour_name from makoto.colours where id = $1";
	$colourResult = pg_query_params($connection, $colourDbQuery, array($colour_id));
	$colour = pg_fetch_array($colourResult);

	$phoneNameDbQuery = "select name, model from makoto.phone, makoto.oem where phone.id = $1 and oem.id = oem_id";
	$phoneNameResult = pg_query_params($connection, $phoneNameDbQuery, array($phone_id));
	$phoneName = pg_fetch_array($phoneNameResult)
?>
<div class="dialog">
	<section class="dialog_header">
		<h2 class="dialog_title">Pricing for <?= $phoneName['model'] ?></h2>
		<span class="dialog_subtitle"><?= $colour['colour_name'] . ', ' . $storage?> GB</span>
	</section>
	<section class="dialog_body">
		<?php if($carrierLinks > 0): ?>
		<h3>Carrier Pricing</h3>
		<?php foreach($priceArray as $price): ?>
		<?php if ($price['is_carrier'] == 't'): ?>
		<div class="dialog_cell">
			<a target="_blank" rel="noopener noreferrer" href="<?= $price['url'] ?>" class="button price_button" style="background-image: url('../images/vendors/<?= $price['vendor_id'] ?>.png')"></a>
			<div class="dialog_price">$<?= $price['price'] ?></div>
			<?php if(!is_null($price['note'])): ?>
			<div class="dialog_note"><?= $price['note'] ?></div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<?php endforeach; ?>
		<?php endif; ?>
		<?php if($vendorLinks > 0): ?>
		<h3>Vendor Pricing</h3>
		<?php foreach($priceArray as $price): ?>
		<?php if ($price['is_carrier'] == 'f'): ?>
		<div class="dialog_cell">
			<a target="_blank" rel="noopener noreferrer" href="<?= $price['url'] ?>" class="button price_button" style="background-image: url('../images/vendors/<?= $price['vendor_id'] ?>.png')"></a>
			<div class="dialog_price">$<?= $price['price'] ?></div>
			<?php if(!is_null($price['note'])): ?>
			<div class="dialog_note"><?= $price['note'] ?></div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<?php endforeach; ?>
		<?php endif; ?>
	</section>
	<section class="dialog_footer">
		<button id="close_pricing_dialog">Close</button>
	</section>
</div>