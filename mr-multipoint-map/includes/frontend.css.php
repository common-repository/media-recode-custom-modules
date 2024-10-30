#mr-multi-map {
	height:<?php if(!empty($settings->map_height)) {
		echo $settings->map_height . 'px;';	
	} else {
		echo '500px;';
	} ?>
	
	width:100%;
}

input.mr-chk-btn {
	display:none;
}

#filter-buttons {
	display:inline-block;
	margin:<?php if(!empty($settings->button_margin)) {
		echo $settings->button_margin . 'px;';	
	} else {
		echo '10px;';
	} ?>
	padding:<?php if(!empty($settings->button_padding)) {
		echo $settings->button_padding . 'px;';	
	} else {
		echo '10px;';
	} ?>
}

#filter-buttons img {
	margin-right:<?php if(!empty($settings->icon_margin)) {
		echo $settings->icon_margin . 'px;';	
	} else {
		echo '5px;';
	} ?>
}