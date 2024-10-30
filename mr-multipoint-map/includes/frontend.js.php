<?php
	
	//Set to -1 so all posts will be loaded and not paginated
	$settings->posts_per_page = -1;

	//Build a query based on the post type selection settings in the 'Content' tab
	$query = FLBuilderLoop::query( $settings );

	if ( $query->have_posts() ) {

		$counter = 0;
		$location_info = array();

		while ( $query->have_posts() ) {

			$query->the_post();


			// If the user supplied a custom field to get the location's title use that, else use the default WP title
			if( !empty($settings->location_name) ) {
				$name = get_post_meta(get_the_ID(), $settings->location_name, true);
			} else {
				$name = get_the_title();
			}

			$location_info[$counter]['name'] = $name;

			// If the user supplied a custom field to get the location's content use that, else use the default WP content
			if( !empty($settings->description_field_name) ) {
				$description = get_post_meta( get_the_ID(), $settings->description_field_name, true );
			} else {
				$description = get_the_content();
			}

			$permalink = get_permalink();

			// Grab the custom field that has the coordinates
			$location = get_post_meta( get_the_ID(), $settings->location_field_name, true );

			// If it's not an array then I assume it's stored in a string as lat,lng like in my Pods filters. Separate lat and lng in an array and assign appropriately. Else it's stored like ACF does it as an array of [lat, lng].
			if ( !is_array($location) ) {
				$geolocation = explode(",", $location);

				$location_info[$counter] = ['lat' => $geolocation[0], 'lng' => $geolocation[1]];
			} else {
				$location_info[$counter]['lat'] = $location['lat'];
				$location_info[$counter]['lng'] = $location['lng'];
			}

			// If using a custom icon or category filter grab the category now
			if ( $settings->use_custom_icon == 'yes' || $settings->use_category_filter == 'yes' ) {

				$category = get_the_terms(get_the_ID(), $settings->post_taxonomy)[0];

				if ( !is_null($category) ) {
					$location_info[$counter]['category'] = $category;
				} else {
					// ['category']['name'] because in the above if $category is an array that has the category name as a name 
					// field. That's why I use the ['category']['name'] down below.
					$location_info[$counter]['category']['name'] = 'Uncategorized';
				}
			}

			// If using custom icon get the icon field name and then grab the image for the icon
			if ( $settings->use_custom_icon == 'yes' ) {
				$icon_id = get_term_meta($category->term_id)[$settings->icon_field_name][0];
				$image = wp_get_attachment_image_url($icon_id, 'full');

				if ( $image != false) {
					$location_info[$counter]['category image'] = $image;
				} else {
					$location_info[$counter]['category image'] = '#';
				}
			}

			// Create the body of the info box content
			$location_info[$counter]['description'] = "<h4><a href='" . $permalink . "'>" . $name . "</a></h4><br />" . $description;

			if($settings->show_marker_radius == 'yes') { 

				if (!empty($settings->radius_field)) {
					$radius_size = get_post_meta(get_the_ID(), $settings->radius_field, true);

					if (empty($radius_size) && !empty($settings->radius_size)) {
						$radius_size =  $settings->radius_size;
					}
				}
				else {
					$radius_size = '20';
				}

				$location_info[$counter]['radius size'] = $radius_size;
				$location_info[$counter]['fill color'] = '#' . $settings->fill_color;
				$location_info[$counter]['stroke color'] = '#' . $settings->stroke_color;
				$location_info[$counter]['stroke weight'] = $settings->stroke_weight;
			}

			$counter++;
    	}

	}

	wp_reset_postdata();

?>

	var markers = new Array();
	markers = <?php echo json_encode($location_info); ?>;
	var settings = new Array();
	settings = <?php echo json_encode($settings); ?>;

	mapMarkers = new Array ();
	alreadyAddedCategories = new Array ();

	filterMarkers = function (category) {
		for (i = 0; i < mapMarkers.length; i++) {
			if(mapMarkers[i]['category'] === category || category.length === 0){
				mapMarkers[i].setVisible(true);
			}
			else {
				mapMarkers[i].setVisible(false);
			}
		}
	}

	function initMap() {
		var map_center = {lat: parseFloat(settings['center_lat']), lng: parseFloat(settings['center_lng'])};

		if (settings['zoom_level']) {
			var zoom_level = parseInt(settings['zoom_level'])
		} else {
			var zoom_level = 10
		}
       	var map = new google.maps.Map(document.getElementById('mr-multi-map'), {
    			zoom: zoom_level,
       			center: map_center
       	});

       	var infowindow = new google.maps.InfoWindow();

       	var use_category_filter = settings['use_category_filter']

       	markers.forEach(function(location) {

			var latlng = new google.maps.LatLng(location['lat'], location['lng']);

	   		marker = new google.maps.Marker({
		   		position: latlng,
		   		map: map,
		   		title: location['name'],
		   		<?php if( $settings->use_category_filter == 'yes' ) { echo "category: location['category']['name'],"; } ?>
		   		<?php if( $location_info[$counter]['category image'] != 'false' ) { echo "icon: location['category image']"; } ?>
			});

			<?php if ($settings->show_marker_radius) { 
					echo 'var circle = new google.maps.Circle({';
					echo 'map: map,';
					echo "radius: parseInt(location['radius size'])*1609,";
					echo "fillColor: location['fill color'],";
					echo "strokeColor: location['stroke color'],";
					echo "strokeWeight: parseInt(location['stroke weight']),";
					echo "center: latlng";
					echo '})';
			} ?>

			marker.addListener('click', function() {
				infowindow.setContent(location['description']);
				infowindow.open(map, this);
			});

	   		mapMarkers.push(marker);

	   		if ( use_category_filter == 'yes' && !alreadyAddedCategories.includes(location['category']['name']) ) {
					document.getElementById("mr-multi-map-filters")
       				.innerHTML += "<div id='filter-buttons' onclick='filterMarkers(\"" + location['category']['name'] + "\")'><input type='checkbox' name='filter' id='" + location['category']['name'] + "' class='mr-chk-btn'><label for='" + location['category']['name'] + "'><a><img src='" + location['category image'] + "'>" + location['category']['name'] + "</a></label></div>"

       				alreadyAddedCategories.push(location['category']['name'])
			}

		});

	}

	jQuery(document).ready(initMap());
