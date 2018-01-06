jQuery('#<?php echo $id ?>').slick({
	'slidesToShow': <?php echo $settings->slider_slidesToShow ?>,
	'slidesToScroll': <?php echo $settings->slider_slidesToScroll ?>,
	'arrows': <?php echo json_encode($module->toBool($settings->slider_arrows)); ?>,
	'dots': <?php echo json_encode($module->toBool($settings->slider_dots)); ?>,
	autoplay: <?php echo json_encode($module->toBool($settings->slider_autoplay)); ?>,
	autoplaySpeed: <?php echo $settings->slider_autoplaySpeed; ?>,
	responsive: [
		{
			breakpoint: 768,
			settings: {
				slidesToShow: 1
			}
		}
	]
});