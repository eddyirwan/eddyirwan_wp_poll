<?php
function slug_admin_menu() {

	//this is the main item for the menu
	add_menu_page(
		'JPN POLLS', //page title
		'JPNM POLL', //menu title
		'manage_options', //capabilities
		'listPoll', //menu slug
		'listPoll'//function
	);

	
	//this is a submenu
	add_submenu_page('listPoll', //parent slug
		'Add New Poll', //page title
		'Add New', //menu title
		'manage_options', //capability
		'listAddPoll', //menu slug
		'listAddPoll'
	); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
		'Update Poll', //page title
		'Update', //menu title
		'manage_options', //capability
		'listUpdatePoll', //menu slug
		'listupdatepoll'
	); 

	add_submenu_page(null, //parent slug
		'Delete Poll', //page title
		'Delete', //menu title
		'manage_options', //capability
		'listDeletePoll', //menu slug
		'listdeletepoll'
	); 

	add_submenu_page(null, //parent slug
		'Add Poll Atribute', //page title
		'Add Atribute', //menu title
		'manage_options', //capability
		'listAddPollAttribute', //menu slug
		'listAddPollAttribute'
	);
}
?>