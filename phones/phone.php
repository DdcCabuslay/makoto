<?php
	$id = $_GET["id"];
	if (is_null($id)) {
		header('Location: index.php');
	}
	$connectString = "dbname=ddccabuslay user=" . $_SERVER['DB_USER'];
	$connection = pg_connect($connectString) or die('Could not connect: ' . pg_last_error());
	$phoneDbQuery = 
	"select oem.name as oem_name, phone.model, os1.name as os_name, os2.name as upgradable_os_name, display_size, display_res_height, display_res_width, display_aspect_ratio, display.display_type, main_camera_res, main_camera_pixel_size, af1.autofocus_type as main_autofocus_type, st1.stabilization_type as main_stabilization_type, main_camera_aperture, dual_camera_res, dual_camera_pixel_size, af2.autofocus_type as dual_autofocus_type, st2.stabilization_type as dual_stabilization_type, dual_camera_aperture, front_camera_res, front_camera_pixel_size, af3.autofocus_type as front_autofocus_type, st3.stabilization_type as front_stabilization_type, front_camera_aperture, processor_oem.name || ' ' || processor.model as processor_model, cores, main_clock, secondary_clock, gpu, expandable_storage, device_length, device_width, device_height, device_weight, battery_size, fast_charging_name, wifi_5, bluetooth_version, nfc, headphone_jack, usb_type, sim_type, glass_type, water_resistance, comment 
		from makoto.phone, makoto.oem, makoto.os as os1, makoto.os as os2, makoto.display, makoto.autofocus as af1, makoto.autofocus as af2, makoto.autofocus as af3, makoto.stabilization as st1, makoto.stabilization as st2, makoto.stabilization as st3, makoto.processor, makoto.processor_oem, makoto.fast_charging, makoto.usb, makoto.sim, makoto.glass
		where phone.id = $1 and oem.id = phone.oem_id and os_id = os1.id and upgradable_os_id = os2.id and display.id = display_type_id and af1.id = main_camera_autofocus_id and (af2.id = dual_camera_autofocus_id or dual_camera_autofocus_id is null) and af3.id = front_camera_autofocus_id and st1.id = main_camera_stabilization_id and (st2.id = dual_camera_stabilization_id or dual_camera_stabilization_id is null) and st3.id = front_camera_stabilization_id and processor_id = processor.id and processor.oem_id = processor_oem.id and fast_charging_id = fast_charging.id and usb_id = usb.id and sim_id = sim.id and glass_id = glass.id";
	$phoneResults = pg_query_params($connection, $phoneDbQuery, array($id));
	$phoneInfo = pg_fetch_array($phoneResults);

	$highlightsDbQuery = 'select is_positive, highlight from makoto.phone_highlights where phone_id = $1';
	$highlightsResults = pg_query_params($connection, $highlightsDbQuery, array($id));
	$positiveHighlightsArray = array();
	$negativeHighlightsArray = array();
	$positiveCounter = 0;
	$negativeCounter = 0;
	while ($row = pg_fetch_array($highlightsResults)) {
		if ($row['is_positive'] == 't') {
			$positiveHighlightsArray[$positiveCounter] = $row['highlight'];
			$positiveCounter++;
		} else {
			$negativeHighlightsArray[$negativeCounter] = $row['highlight'];
			$negativeCounter++;			
		}
	}

	$colourDbQuery = "select phone_colours.colour_id, colour_hex, secondary_colour_hex
		from makoto.colours, makoto.phone_colours
		where phone_id = $1 and colours.id = colour_id";
	$colourResults = pg_query_params($connection, $colourDbQuery, array($id));
	$colourArray = array();
	$counter = 0;
	while ($row = pg_fetch_array($colourResults)) {
		$colourArray[$counter]['colour_id'] = $row['colour_id'];
		$colourArray[$counter]['colour_hex'] = $row['colour_hex'];
		$colourArray[$counter]['secondary_colour_hex'] = $row['secondary_colour_hex'];
		$counter++;
	}

	$videoResDbQuery = ' select is_main_camera, resolution, fps from makoto.phone_video_resolutions where phone_id = $1 order by resolution desc, fps desc';
	$videoResResults = pg_query_params($connection, $videoResDbQuery, array($id));
	$videoResMainArray = array();
	$videoResFrontArray = array();
	while ($row = pg_fetch_array($videoResResults)) {
		if ($row['is_main_camera'] == 't') {
			if (is_null($videoResMainArray[$row['resolution']])) {
				$videoResMainArray[$row['resolution']] = $row['resolution'] . 'p @ ' . $row['fps'] . 'fps, ';
			} else {
				$videoResMainArray[$row['resolution']] = $videoResMainArray[$row['resolution']] . $row['fps'] . 'fps, ';
			}
		} else {
			if (is_null($videoResFrontArray[$row['resolution']])) {
				$videoResFrontArray[$row['resolution']] = $row['resolution'] . 'p @ ' . $row['fps'] . 'fps, ';
			} else {
				$videoResFrontArray[$row['resolution']] = $videoResFrontArray[$row['resolution']] . $row['fps'] . 'fps, ';
			}			
		}
	}

	$storageDbQuery = 'select ram, storage from makoto.phone_storage_configurations where phone_id = $1';
	$storageResults = pg_query_params($connection, $storageDbQuery, array($id));
	$storageArray = array();
	$counter = 0;
	while ($row = pg_fetch_array($storageResults)) {
		$storageArray[$counter]['ram'] = $row['ram'];
		$storageArray[$counter]['storage'] = $row['storage'];
		$counter++;
	}

	$ramCountQuery = 'select count(*) from (select ram from makoto.phone_storage_configurations where phone_id = $1 group by ram) as ram;';
	$ramCountResults = pg_query_params($connection, $ramCountQuery, array($id));
	$ramCount = pg_fetch_array($ramCountResults);

	$maxStorageAndRamDbQuery = 'select max(ram) as max_ram, max(storage) as max_storage from makoto.phone_storage_configurations where phone_id = $1';
	$maxStorageAndRamResults = pg_query_params($connection, $maxStorageAndRamDbQuery, array($id));
	$maxStorageAndRam = pg_fetch_array($maxStorageAndRamResults);
?>
<!DOCTYPE html>
<html>
<head>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../styles/style.css">
	<link rel="stylesheet" type="text/css" href="../styles/theme.css">
	<link rel="stylesheet" type="text/css" href="../styles/product.css">
	<link rel="stylesheet" type="text/css" href="../styles/phones.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Google Pixel 2 XL - Makoto</title>
</head>
<body>
	<?php include 'header.php' ?>
<!-- 	<header class="subheader">
		<section>
			<h1 class="product_title">Google Pixel 2 XL</h1>
		</section>
		<section>
			<a target="_blank" rel="noopener noreferrer" href="https://store.google.com/product/pixel_2" class="button stroked_button">Official Website</a>
		</section>
	</header> -->
	<main class="opaque">
		<section class="product_overview">
			<div class="product_media">
				<img class="product_image" src="../images/phones/0/0.png">
				<div class="image_thumbs">
					<img class="image_thumb" src="../images/phones/0/0.png">
					<img class="image_thumb" src="../images/phones/0/1.png">
				</div>
			</div>
			<div class="product_info">
				<div class="info_window">
					<span class="product_oem"><?= $phoneInfo['oem_name'] ?></span>
					<h1 class="product_title"><?= $phoneInfo['model'] ?></h1>
					<div id="product_highlights">
						<div class="highlights_table">
							<ul class="positive_highlights">
								<?php foreach($positiveHighlightsArray as $positiveHighlight): ?>
								<li><?= $positiveHighlight ?></li>
								<?php endforeach; ?>
							</ul>
							<ul class="negative_highlights">
								<?php foreach($negativeHighlightsArray as $negativeHighlight): ?>
								<li><?= $negativeHighlight ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
					<div class="info_window_row colour_row">
						<?php foreach($colourArray as $colour): ?>
						<?php if(!is_null($colour['secondary_colour_hex'])): ?>
						<button class="info_window_row_button colour_button">
							<div class="colour" style="background: linear-gradient(#<?=$colour['colour_hex']?>, #<?=$colour['colour_hex']?> 50%, #<?=$colour['secondary_colour_hex']?> 51%);"></div>
						</button>
						<?php else: ?>
						<button class="info_window_row_button colour_button">
							<div class="colour" style="<?= htmlspecialchars('background: #' . $colour['colour_hex'] . ';'); ?>"></div>
						</button>
						<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<div class="info_window_row storage_row">
						<?php if($ramCount['count'] == '1'): ?>
						<?php foreach($storageArray as $storage): ?>
						<button class="info_window_row_button storage_button">
							<div class="storage_size"><?= $storage['storage'] ?> GB</div>
						</button>
						<?php endforeach; ?>
						<?php else: ?>
						<?php foreach($storageArray as $storage): ?>
						<button class="info_window_row_button storage_button">
							<div class="storage_size"><?= $storage['storage'] ?> GB/<?= $storage['ram'] ?> GB</div>
						</button>							
						<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<div class="info_window_footer">
						<!-- cheapest vendor price -->
						<a target="_blank" rel="noopener noreferrer" href="" class="button filled_button">$1159.00 on Google Store</a>
						<button>Carrier and Vendor Pricing</button>
					</div>
				</div>
			</div>
		</section>
		<section class="product_details">
			<div id="product_description">
				<h3>Daniel's Comments</h3>
				<p><?= $phoneInfo['comment'] ?></p>
			</div>
			<div id="product_specs">
				<h3>Technical Specifications</h3>
				<div class="spec_table">
					<div class="spec_table_row">
						<h4 class="spec_table_header">Operating System</h4>
						<i class="fas fa-angle-down fa-fw"></i>
						<div class="spec_table_spec_overview">
							<?=$phoneInfo['os_name']?>
						</div>
						<div class="spec_table_spec">
							<span class="spec_table_item"><?=$phoneInfo['os_name']?> preinstalled</span>
							<span class="spec_table_item">Upgradable to <?=$phoneInfo['upgradable_os_name']?>
								<a class="footnote_ref" href="#update_notice">
									<sup>3</sup>
								</a>
							</span>
						</div>
					</div>
					<div class="spec_table_row">
						<h4 class="spec_table_header">Display</h4>
						<i class="fas fa-angle-down fa-fw"></i>
						<div class="spec_table_spec_overview">
							<?=number_format($phoneInfo['display_size'], 1)?>" <?=$phoneInfo['display_res_width']?>p <?=$phoneInfo['display_type']?>
						</div>
						<div class="spec_table_spec">
							<span class="spec_table_item"><?=number_format($phoneInfo['display_size'], 1)?>"</span>
							<span class="spec_table_item"><?=$phoneInfo['display_res_height']?> &times; <?=$phoneInfo['display_res_width']?></span>
							<span class="spec_table_item"><?=$phoneInfo['display_type']?></span>
							<span class="spec_table_item"><?=$phoneInfo['display_aspect_ratio']?></span>
						</div>
					</div>
					<div class="spec_table_row">
						<h4 class="spec_table_header">Cameras</h4>
						<i class="fas fa-angle-down fa-fw"></i>
						<div class="spec_table_spec_overview">
							<?php if (!is_null($phoneInfo['dual_camera_res'])): ?>
							Rear: <?=$phoneInfo['main_camera_res']?> MP + <?=$phoneInfo['dual_camera_res']?> MP &middot; Front: <?=$phoneInfo['front_camera_res']?> MP
							<?php else: ?>
							Rear: <?=$phoneInfo['main_camera_res']?> MP &middot; Front: <?=$phoneInfo['front_camera_res']?> MP
							<?php endif; ?>
						</div>
						<div class="spec_table_spec">
							<div class="spec_table_subtable">
								<?php if (!is_null($phoneInfo['dual_camera_res'])): ?>
								<h5>Rear Cameras</h5>
								<span class="spec_table_item">
									<?=$phoneInfo['main_camera_res']?> MP + <?=$phoneInfo['dual_camera_res']?> MP (<?=$phoneInfo['dual_camera_type']?>)
								</span>
								<span class="spec_table_item">
									<?=$phoneInfo['main_camera_pixel_size']?> &micro;m (Main); <?=$phoneInfo['dual_camera_pixel_size']?> MP (<?=$phoneInfo['dual_camera_type']?>)
								</span>
								<span class="spec_table_item">
									<?=$phoneInfo['main_autofocus_type']?> (Main); <?=$phoneInfo['dual_autofocus_type']?> (<?=$phoneInfo['dual_camera_type']?>)
								</span>
								<span class="spec_table_item">
									<?=$phoneInfo['main_stabilization_type']?> (Main); <?=$phoneInfo['dual_stabilization_type']?> (<?=$phoneInfo['dual_camera_type']?>)
									</span>
								<span class="spec_table_item">
									f/<?=$phoneInfo['main_camera_aperture']?> (Main) + f/<?=$phoneInfo['dual_camera_aperture']?> (<?=$phoneInfo['dual_camera_type']?>)aperture
								</span>
								<?php else: ?>
								<h5>Rear Camera</h5>
								<span class="spec_table_item"><?=$phoneInfo['main_camera_res']?> MP</span>
								<span class="spec_table_item"><?=$phoneInfo['main_camera_pixel_size']?> &micro;m</span>
								<span class="spec_table_item"><?=$phoneInfo['main_autofocus_type']?></span>
								<span class="spec_table_item"><?=$phoneInfo['main_stabilization_type']?></span>
								<span class="spec_table_item">f/<?=$phoneInfo['main_camera_aperture']?> aperture</span>
								<?php endif; ?>
							</div>
							<div class="spec_table_subtable">
								<h5>Front Camera</h5>
								<span class="spec_table_item"><?=$phoneInfo['front_camera_res']?> MP</span>
								<span class="spec_table_item"><?=$phoneInfo['front_camera_pixel_size']?> &micro;m</span>
								<span class="spec_table_item"><?=$phoneInfo['front_autofocus_type']?></span>
								<span class="spec_table_item"><?=$phoneInfo['front_stabilization_type']?></span>
								<span class="spec_table_item">f/<?=$phoneInfo['front_camera_aperture']?> aperture</span>
							</div>
							<div class="spec_table_subtable">
								<h5>Rear Camera Video</h5>
								<?php foreach($videoResMainArray as $mainRes): ?>
								<span class="spec_table_item">
									<?= substr($mainRes, 0, -2) ?>
								</span>
								<?php endforeach; ?>
							</div>
							<div class="spec_table_subtable">
								<h5>Front Camera Video</h5>
								<?php foreach($videoResFrontArray as $frontRes): ?>
								<span class="spec_table_item">
									<?= substr($frontRes, 0, -2) ?>
								</span>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="spec_table_row">
						<h4 class="spec_table_header">Processor</h4>
						<i class="fas fa-angle-down fa-fw"></i>
						<div class="spec_table_spec_overview">
							<?=$phoneInfo['processor_model']?>
						</div>
						<div class="spec_table_spec">
							<span class="spec_table_item"><?=$phoneInfo['processor_model']?></span>
							<span class="spec_table_item"><?=$phoneInfo['main_clock']?> Ghz + <?=$phoneInfo['secondary_clock']?> Ghz 
								<?php if ($phoneInfo['cores'] == '8'): ?>
								Octa-core
								<?php elseif ($phoneInfo['cores'] == '4'): ?>
								Quad-core 
								<?php elseif ($phoneInfo['cores'] == '2'): ?>
								Dual-core 
								<?php elseif ($phoneInfo['cores'] == '1'): ?>
								Single-core 
								<?php endif; ?>
							</span>
							<span class="spec_table_item"><?=$phoneInfo['gpu']?></span>
						</div>
					</div>
					<div class="spec_table_row">
						<h4 class="spec_table_header">Memory &amp; Storage</h4>
						<i class="fas fa-angle-down fa-fw"></i>
						<div class="spec_table_spec_overview">
							<?php if ($ramCount['count'] == '1'): ?>
							RAM: <?= $maxStorageAndRam['max_ram'] ?> GB &middot; Storage: Up to <?= $maxStorageAndRam['max_storage'] ?> GB
							<?php else: ?>
							RAM: Up to <?= $maxStorageAndRam['max_ram'] ?> GB &middot; Storage: Up to <?= $maxStorageAndRam['max_storage'] ?> GB
							<?php endif; ?>
						</div>
						<div class="spec_table_spec">
							<span class="spec_table_item">RAM: 
								<?php 
									$ramStr = '';
									if ($ramCount['count'] == 1) {
										echo $maxStorageAndRam['max_ram'] . ' GB';
									} else {
										foreach($storageArray as $storage) {
											$ramStr = $ramStr . $storage['ram'] . ' GB, ';
										}
										echo substr($ramStr, 0, -2);
									}
								?>
							</span>
							<span class="spec_table_item">Internal Storage: 
								<?php 
								$storageStr = '';
								foreach($storageArray as $storage) {
									$storageStr = $storageStr . $storage['storage'] . ' GB, ';
								}
								echo substr($storageStr, 0, -2);
								?>
							</span>
							<?php if ($phoneInfo['expandable_storage'] == 'TRUE'): ?>
							<span class="spec_table_item">Expandable memory via microSD</span>
							<?php endif; ?>
						</div>
					</div>
					<div class="spec_table_row">
						<h4 class="spec_table_header">Dimensions &amp; Weight</h4>
						<i class="fas fa-angle-down fa-fw"></i>
						<div class="spec_table_spec_overview">
							Dimensions: <?=$phoneInfo['device_length']?>mm &times; <?=$phoneInfo['device_width']?>mm &times; <?=$phoneInfo['device_height']?>mm &middot; Weight: <?=$phoneInfo['device_weight']?>g
						</div>
						<div class="spec_table_spec">
							<span class="spec_table_item">Length: <?=$phoneInfo['device_length']?>mm</span>
							<span class="spec_table_item">Width: <?=$phoneInfo['device_width']?>mm</span>
							<span class="spec_table_item">Height: <?=$phoneInfo['device_height']?>mm</span>
							<span class="spec_table_item">Weight: <?=$phoneInfo['device_weight']?>g</span>
						</div>
					</div>
					<div class="spec_table_row">
						<h4 class="spec_table_header">Battery</h4>
						<i class="fas fa-angle-down fa-fw"></i>
						<div class="spec_table_spec_overview"><?=$phoneInfo['battery_size']?> mAh</div>
						<div class="spec_table_spec">
							<span class="spec_table_item"><?=$phoneInfo['battery_size']?> mAh</span>
							<?php if (!is_null($phoneInfo['fast_charging_name'])): ?>
							<span class="spec_table_item">Fast Charging via <?=$phoneInfo['fast_charging_name']?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="spec_table_row">
						<h4 class="spec_table_header">Wireless</h4>
						<i class="fas fa-angle-down fa-fw"></i>
						<div class="spec_table_spec_overview">
							<?php if ($phoneInfo['wifi_5']): ?>
							Wi-Fi 2.4G + 5G &middot; Bluetooth <?=number_format($phoneInfo['bluetooth_version'], 1)?>
							<?php else: ?>
							Wi-Fi 2.4G &middot; Bluetooth <?=number_format($phoneInfo['bluetooth_version'], 1)?>
							<?php endif;?>
						</div>
						<div class="spec_table_spec">
							<span class="spec_table_item">
							<?php if ($phoneInfo['wifi_5'] == 'TRUE'): ?>
							Wi-Fi 2.4G + 5G
							<?php else: ?>
							Wi-Fi 2.4G
							<?php endif;?>								
							</span>
							<span class="spec_table_item">Bluetooth <?=number_format($phoneInfo['bluetooth_version'], 1)?></span>
							<?php if ($phoneInfo['nfc'] == 'TRUE'): ?>
							<span class="spec_table_item">NFC</span>
							<?php endif;?>
						</div>
					</div>
					<div class="spec_table_row">
						<h4 class="spec_table_header">Ports</h4>
						<i class="fas fa-angle-down fa-fw"></i>
						<div class="spec_table_spec_overview"><?=$phoneInfo['usb_type']?></div>
						<div class="spec_table_spec">
							<?php if ($phoneInfo['headphone_jack'] == 'TRUE'): ?>
							<span class="spec_table_item">3.5mm jack</span>
							<?php else: ?>
							<span class="spec_table_item">No 3.5mm jack; dongle included</span>
							<?php endif; ?>
							<span class="spec_table_item"><?=$phoneInfo['usb_type']?></span>
							<span class="spec_table_item"><?=$phoneInfo['sim_type']?></span>
						</div>
					</div>
					<div class="spec_table_row">
						<h4 class="spec_table_header">Materials</h4>
						<i class="fas fa-angle-down fa-fw"></i>
						<div class="spec_table_spec_overview">
							<?php if (!is_null($phoneInfo['glass_type'])): ?>
							<?=$phoneInfo['glass_type']?> &middot;
							<?php endif; ?>
							<?php if (!is_null($phoneInfo['water_resistance'])): ?>
							IP<?=$phoneInfo['water_resistance']?>
							<?php endif; ?>
						</div>
						<div class="spec_table_spec">
							<?php if (!is_null($phoneInfo['glass_type'])): ?>
							<span class="spec_table_item"><?=$phoneInfo['glass_type']?></span>
							<?php endif; ?>
							<?php if (!is_null($phoneInfo['water_resistance'])): ?>
							<span class="spec_table_item">IP<?=$phoneInfo['water_resistance']?> water resistance</span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section>
			<ol class="footnotes">
				<li class="footnote" id="carrier_notice">
					Prices are based off carriers' two year term offerings. Prices may change depending on available storage capacities, colours, ongoing promotions and are subject to change without notice. Check with your local carrier for the most up to date pricing.
				</li>
				<li class="footnote" id="vendor_notice">
					Vendor pricing is subject to change without notice. Check each vendor for the most up to date pricing.
				</li>
				<li class="footnote" id="update_notice">
					Updates may be subject to carrier approval and testing before being released. If you purchase this phone through a carrier, check with them to find out when an update will be available for this device.
				</li>
			</ol>
		</section>
	</main>
</body>
</html>