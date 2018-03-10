<?php
	$connectString = "dbname=ddccabuslay user=" . $_SERVER['DB_USER'];
	$connection = pg_connect($connectString) or die('Could not connect: ' . pg_last_error());
	$dbQuery = "select phone.id, oem.name, model, min(price) as min_price, max(price) as max_price from makoto.oem, makoto.phone, makoto.phone_pricing, makoto.vendor where oem_id = oem.id and phone.id = phone_pricing.phone_id and vendor.id = vendor_id group by phone.id, oem.name order by release, oem.name, model";
	$results = pg_query($connection, $dbQuery);
	$results_array = array();
	$counter = 0;
	while ($row = pg_fetch_array($results)) {
		$results_array[$counter]['id'] = $row['id'];
		$results_array[$counter]['model'] = $row['model'];
		$results_array[$counter]['oem'] = $row['name'];
		$results_array[$counter]['min_price'] = $row['min_price'];
		$results_array[$counter]['max_price'] = $row['max_price'];
		$counter++;
	}
?>
<?php foreach ($results_array as $result): ?>
<a href="phone.php?id=<?=$result['id']?>" class="item">
	<img class="item_img" src="../images/phones/<?=$result['id']?>/thumb.jpg">
	<div class="item_info">
		<div class="item_name">
			<?=$result['model']?>
		</div>
		<div class="item_oem">
			<?=$result['oem']?>
		</div>
		<div class="item_pricing">
			<?php if ($result['min_price'] == $result['max_price']): ?>
			$<?=$result['min_price']?>
			<?php else: ?>
			$<?=$result['min_price']?> - $<?=$result['max_price']?>
			<?php endif; ?>
		</div>
	</div>
</a>
<?php endforeach;?>