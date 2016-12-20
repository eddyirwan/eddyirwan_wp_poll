<?php
/*
Plugin Name: EDDYIRWAN POLL
Plugin URI: http://www.facebook.com/eddyirwan
Version: 1
Author: Eddy Irwan
Email: eddyirwan@gmail.com
Phone: +60109826521 / +60122856521
Description: POLL for Malaysian Government Website
*/



require_once( plugin_dir_path( __FILE__ ) . "settings.php");
require_once( plugin_dir_path( __FILE__ ) . "frontend.php");
require_once( plugin_dir_path( __FILE__ ) . "backend.php");


#register_activation_hook(__FILE__, 'createDB');
#register_deactivation_hook( __FILE__, 'deleteDB' );
add_action( 'wp_ajax_ei_voteThruAjax', 'ei_voteThruAjax' );
add_action( 'wp_ajax_nopriv_ei_voteThruAjax', 'ei_voteThruAjax' );
add_action( 'wp_ajax_ei_seeResultFromAjax', 'ei_seeResultFromAjax' );
add_action( 'wp_ajax_nopriv_ei_seeResultFromAjax', 'ei_seeResultFromAjax' );
add_action( 'init', 'custom_lang_found' );
add_action('admin_menu','slug_admin_menu');

add_shortcode( PLUGIN_NAME , 'frontend' );

function listPoll() {
	$instance1 = new ListPoll();
}
function listAddPoll() {
	$instance1 = new listAddPoll();
}
function listDeletePoll() {
	$instance1 = new listDeletePoll();
}
function listUpdatePoll() {
	$instance1 = new listUpdatePoll();
}
function listAddPollAttribute() {
	$instance1 = new listAddPollAttribute();
}

?>