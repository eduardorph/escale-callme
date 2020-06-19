<?php
register_activation_hook( ESCALE_CALLME_PLUGIN_FILE_URL, 'escale_callme_activation' );
function escale_callme_activation() {
	if ( !current_user_can( 'activate_plugins' ) ) return;

	global $wpdb;

	$escale_callme_db_version = '1.0';
	$table_name = $wpdb->prefix . "escale_callme_leads"; 
	$charset_collate = $wpdb->get_charset_collate();


	if($wpdb->get_var( "show tables like '$table_name'" ) != $table_name) 
	{

		$sql = "CREATE TABLE $table_name (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  company varchar(255) DEFAULT NULL,
				  channel varchar(255) DEFAULT NULL,
				  url varchar(255) DEFAULT NULL,
				  googleClientID varchar(255) DEFAULT NULL,
				  mediaId varchar(255) DEFAULT NULL,
				  name varchar(255) DEFAULT NULL,
				  cpf varchar(255) DEFAULT NULL,
				  phone varchar(255) DEFAULT NULL,
				  email varchar(255) DEFAULT NULL,
				  postcode varchar(255) DEFAULT NULL,
				  status_code varchar(255) DEFAULT NULL,
				  message text,
				  created_at datetime DEFAULT NULL,
				  UNIQUE KEY id (id)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option( 'escale_callme_db_version', $escale_callme_db_version );
	}
}