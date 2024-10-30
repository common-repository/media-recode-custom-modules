<div id="mr-multi-map"></div>

<?php 
	if ( $settings->use_category_filter == 'yes' ) {
		if ( !empty($settings->filter_by_text) ) {
			echo '<h2>' . $settings->filter_by_text . '</h2>';
		} else {
			echo '<h2>Filter by category:</h2>';
		}
		echo '<div id="mr-multi-map-filters">';
		echo '</div>';
	}


	echo '<script src="https://maps.googleapis.com/maps/api/js?key=' . $settings->map_api_key . '"></script>';
?>