<?php
/**
 * Plugin Name: Media Recode Custom Modules
 * Plugin URI: https//www.mediarecode.com
 * Description: Custom Beaver Builder modules developed by Media Recode.
 * Version: 1.8.3
 * Author: Matt Ryan
 * Author URI: https://www.mediarecode.com
 * License: GPLv2
 */

define( 'MR_MODULES_DIR', plugin_dir_path( __FILE__ ) );
define( 'MR_MODULES_URL', plugins_url( '/', __FILE__ ) );

function mr_load_modules() {
    if ( class_exists( 'FLBuilder' ) ) {
        require_once 'mr-multipoint-map/mr-multipoint-map.php';
        //require_once 'mr-breaking-news/mr-breaking-news.php';
        require_once 'enhancements/membership-requirement/membership-requirement-row.php';
    }
}

function mr_load_enhancements() {
    if ( class_exists( 'FLBuilder' ) ) {
        require_once 'enhancements/membership-requirement/membership-requirement-row.php';
    }
}

add_action( 'init', 'mr_load_modules' );
add_action( 'plugins_loaded', 'mr_load_enhancements' );