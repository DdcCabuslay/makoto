<?php
	$connectString = "dbname=ddccabuslay user=" . $_SERVER['DB_USER'];
	$connection = pg_connect($connectString) or die('Could not connect: ' . pg_last_error());
	$dbQuery = "select phone.id, oem.name, model, min(price) as price from makoto.oem, makoto.phone, makoto.phone_pricing, makoto.vendor where oem_id = oem.id and phone.id = phone_pricing.phone_id and vendor.is_carrier = FALSE and vendor.id = vendor_id group by phone.id, oem.name";
	$results = pg_query($connection, $dbQuery);
	$results_array = array();
	$counter = 0;
	while ($row = pg_fetch_array($results)) {
		$results_array[$counter]['id'] = $row['id'];
		$results_array[$counter]['model'] = $row['model'];
		$results_array[$counter]['oem'] = $row['name'];
		$results_array[$counter]['price'] = $row['price'];
		$counter++;
	}
?>
<div class="item_grid">
	<?php foreach ($results_array as $result): ?>
	<a href="phone.php?id=<?=$result['id']?>" class="item">
		<img class="item_img" src="../images/phones/<?=$result['id']?>/thumb.jpg">
		<div class="item_info">
			<div class="item_name">
				<?=$result['model']?>
			</div>
			<span class="item_oem">
				<?=$result['oem']?>
			</span>
			<span class="item_primary_price">$<?=$result['price']?></span>
		</div>
	</a>
	<?php endforeach;?>
</div>