<?php
define("TABLENAMEMASTER","ei_polllist");
define("TABLENAMEDETAIL","ei_polllist_detail");
define("APPS_NAME", "UNDIAN");
define("PLUGIN_NAME", "abc");

/* please dont touch */

function createDB() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name1 = $wpdb->prefix . TABLENAMEMASTER;
	$table_name2 = $wpdb->prefix . TABLENAMEDETAIL;
	$sql1 = "CREATE TABLE $table_name1 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		created_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		status smallint(5) NOT NULL,
		title_default varchar(150) NOT NULL,
		title_en varchar(150) NOT NULL,
		create_by bigint(20) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	$sql2 = "CREATE TABLE $table_name2 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		table_master mediumint(9) NOT NULL,
		title_default varchar(50) NOT NULL,
		title_en varchar(50) NOT NULL,
		create_by bigint(20) NOT NULL,
		vote bigint(20) NOT NULL,
		checked TINYINT NOT NULL DEFAULT '0',
		UNIQUE KEY id (id),
		INDEX table_master (table_master)
	) $charset_collate;";

	$sql3 = "
		INSERT INTO `$table_name1` (`id`, `created_time`, `status`, `title_default`, `title_en`, `create_by`) VALUES
		(1, '2016-12-11 17:09:59', 1, 'Apa pendapat anda mengenai Portal Rasmi JABATAN PENDAFTARAN NEGARA yang baru?', 
		'What is your opinion about JPN''s new Official Portal?*', 1); ";

	$sql4 = "
		INSERT INTO `$table_name2` (`id`, `table_master`, `title_default`, `title_en`, `create_by`, `vote`, `checked`) VALUES
		(1, 1, 'Sangat Menarik', 'Very Interesting', 1, 4, 1),
		(2, 1, 'Menarik', 'Interesting', 1, 2, 0),
		(3, 1, 'Sederhana', 'Moderate', 1, 4, 0),
		(4, 1, 'Tidak Menarik', 'Not Interesting At All', 1, 1, 0);";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql1.$sql2);
    dbDelta($sql3);
    dbDelta($sql4);
}

function deleteDB() {
	global $wpdb;
    $table_name1 = $wpdb->prefix . TABLENAMEMASTER;
	$table_name2 = $wpdb->prefix . TABLENAMEDETAIL;

    $wpdb->query("DROP TABLE IF EXISTS $table_name1");
    $wpdb->query("DROP TABLE IF EXISTS $table_name2");
	
}

?>