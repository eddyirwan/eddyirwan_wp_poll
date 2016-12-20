<?php
require_once( plugin_dir_path( __FILE__ ) . "backend".DIRECTORY_SEPARATOR."controller.class.php");
require_once( plugin_dir_path( __FILE__ ) . "backend".DIRECTORY_SEPARATOR."menuslug.php");
require_once( plugin_dir_path( __FILE__ ) . "backend".DIRECTORY_SEPARATOR."validation.php");


class listPoll extends Controller {
	function __construct() {
		parent::__construct();
	}
	public function post_listpoll() {
		// none
	}
	protected function getpollchild($id=0) {
		global $wpdb;
		$table_name = $wpdb->prefix . TABLENAMEDETAIL;
  	    $rows = $wpdb->get_results("SELECT * from $table_name WHERE table_master = $id");
  	    return $rows;
	}
	public function get_listpoll() {
		global $wpdb;
		global $reg_errors;
     	$table_name = $wpdb->prefix . TABLENAMEMASTER;
  	    $rows = $wpdb->get_results("SELECT * from $table_name");
  	    for ($x = 0; $x < count($rows) ; $x++) {
  	    	$rows[$x]->child=$this->getpollchild($rows[$x]->id);
  	    }
  	    # kalau tak tau apa aku buat uncomment line dibawah untuk tengok data structure
  	    #echo "<pre>".print_r($rows,true)."</pre>";
		require_once( plugin_dir_path( __FILE__ ) . "views/admin_list.php");
	}
}

class listDeletePoll extends Controller {
	function __construct() {
		parent::__construct();
	}
	function post_listDeletePoll() {
		// none
	}
	function get_listDeletePoll() {
		global $wpdb;
		$idfromUrl= (isset($_GET["id"])? $_GET["id"]:'');
		if ($idfromUrl) {
			$task=(isset($_GET["task"])? $_GET["task"]:'');
			if ($task=="clearattribute") {
		        
		        $table_name = $wpdb->prefix . TABLENAMEDETAIL;
		        $wpdb->delete( $table_name, array( 
		        	'table_master' => $idfromUrl
		        ));
			}
			else if ($task == "deleteall") {
				$table_name = $wpdb->prefix . TABLENAMEMASTER;
	        	$wpdb->delete( $table_name, array( 
	        		'id' => $idfromUrl
	        	));
		        
		        $table_name = $wpdb->prefix . TABLENAMEDETAIL;
		        $wpdb->delete( $table_name, array( 
		        	'table_master' => $idfromUrl
		        ));
			}
			else if ($task == "deleteattribute") {
		        $table_name = $wpdb->prefix . TABLENAMEDETAIL;
		        $wpdb->delete( $table_name, array( 
		        	'id' => $idfromUrl
		        ));
			}
			
		}
		wp_redirect(admin_url().'admin.php?page=listPoll');
	}
}

class listUpdatePoll extends Controller {
	function __construct() {
		parent::__construct();
	}
	function post_listupdatepoll() {
		global $wpdb;
		global $reg_errors;

		$idfromUrl=$_GET["id"];
		$table_name = $wpdb->prefix . TABLENAMEMASTER;
        $rows = $wpdb->get_results("SELECT * from $table_name where id = $idfromUrl");
        $table_name = $wpdb->prefix . TABLENAMEDETAIL;
        $rows1 = $wpdb->get_results("SELECT * from $table_name where table_master = $idfromUrl");	
        $maxAttr=count($rows1);

		$reg_errors = new WP_Error;
		$validation1 = new validation($reg_errors,array('title'=>'check_empty_text'),array('en'));
		$validation1->multiLanguageInputForm();

		$validation1->dynamicMultiLanguageInputForm($maxAttr);
		$reg_errors=$validation1->get_reg_errors();
		if( is_wp_error( $reg_errors ) && ! empty( $reg_errors->errors ) ) {		
	        require_once(ABSPATH . 'wp-admin/admin-header.php');
			require_once( plugin_dir_path( __FILE__ ) . "views/admin_updatepoll.php");
		}
		else {
			$title_default = sanitize_text_field(  (isset($_POST["title-default"])? $_POST["title-default"]:''));
			$title_en = sanitize_text_field(  (isset($_POST["title-en"])? $_POST["title-en"]:''));
			$status = sanitize_text_field(  (isset($_POST["status"])? $_POST["status"]:''));
			$table_name = $wpdb->prefix . TABLENAMEMASTER;
			$updated = $wpdb->update("$table_name", array(
				 'title_default' => $title_default,
				 'status' => $status,
	             'title_en' => $title_en),
				array('id'=>$idfromUrl));
			$table_name = $wpdb->prefix . TABLENAMEDETAIL;
			for ($w=0;$w<$maxAttr;$w++) {
				$text_default = sanitize_text_field(  (isset($_POST["attr$w-default"])? $_POST["attr$w-default"]:''));
				$text_en = sanitize_text_field(  (isset($_POST["attr$w-en"])? $_POST["attr$w-en"]:''));
				$updated = $wpdb->update("$table_name", array(
				 'title_default' => $text_default,
	             'title_en' => $text_en),
				array('id'=>$rows1[$w]->id));
				#echo "<p>".$wpdb->last_query."</p>";
			}
			wp_redirect(admin_url().'admin.php?page=listPoll');
			#echo $wpdb->last_query;
			
		}
	}
	function get_listupdatepoll() {
		global $wpdb;
		global $reg_errors;
		$idfromUrl=$_GET["id"];
        $table_name = $wpdb->prefix . TABLENAMEMASTER;
        $rows = $wpdb->get_results("SELECT * from $table_name where id = $idfromUrl");
        $table_name = $wpdb->prefix . TABLENAMEDETAIL;
        $rows1 = $wpdb->get_results("SELECT * from $table_name where table_master = $idfromUrl");	
        $maxAttr=count($rows1);
        require_once( plugin_dir_path( __FILE__ ) . "views/admin_updatepoll.php");
	}
}

class listAddPoll extends Controller {
	function __construct() {
		parent::__construct();
	}
	function post_listAddPoll() {
		global $reg_errors;
		$reg_errors = new WP_Error;
		$validation1 = new validation($reg_errors,array('title'=>'check_empty_text'),array('en'));
		$validation1->multiLanguageInputForm();

		$maxAttr = sanitize_text_field( (isset($_POST["maxAttr"])? $_POST["maxAttr"]:'') );
		$validation1->dynamicMultiLanguageInputForm($maxAttr);
		$reg_errors=$validation1->get_reg_errors();
		if ( is_wp_error( $reg_errors ) && ! empty( $reg_errors->errors ) ) {
			require_once(ABSPATH . 'wp-admin/admin-header.php');
			require_once( plugin_dir_path( __FILE__ ) . "views/admin_addpoll.php");
		}
		else {
			global $wpdb;
			$table_name1= $wpdb->prefix . TABLENAMEMASTER;
			$table_name2= $wpdb->prefix . TABLENAMEDETAIL;
			$title_default = sanitize_text_field(  (isset($_POST["title-default"])? $_POST["title-default"]:''));
			$title_en = sanitize_text_field(  (isset($_POST["title-en"])? $_POST["title-en"]:''));
			$status = sanitize_text_field(  (isset($_POST["status"])? $_POST["status"]:''));
			$user = wp_get_current_user();
        	$wpdb->insert( $table_name1, 
	            array( 
	                'title_default' => $title_default,
	                'title_en' => $title_en,
	                'create_by' => $user->ID,
	                'status' => $status
	            )
	        );	
	        $lastid = $wpdb->insert_id;  
	        for ($y=0;$y<$maxAttr;$y++) {
	        	
	        	$text_default = sanitize_text_field(  (isset($_POST["attr$y-default"])? $_POST["attr$y-default"]:''));
	        	$text_en = sanitize_text_field(  (isset($_POST["attr$y-en"])? $_POST["attr$y-en"]:''));
	        	$checked=($y==0)? '1':'0';
	        	$wpdb->insert( $table_name2, 
		            array( 
		            	'table_master' => $lastid,
		                'title_default' => $text_default,
		                'title_en' => $text_en,
		                'create_by' => $user->ID,
		                'vote' => '0',
		                'checked' => $checked
		            )
	        	);
	        	#echo "<pre>".$wpdb->last_query."</pre>";
	        }      
			wp_redirect(admin_url().'admin.php?page=listPoll');
		}
	}
	function get_listAddPoll() {
		global $reg_errors;
		$maxAttr    = sanitize_text_field((isset($_GET["maxAttr"])? $_GET["maxAttr"]:'5'));

		require_once( plugin_dir_path( __FILE__ ) . "views/admin_addpoll.php");
	}

}


class listAddPollAttribute extends Controller {
	function __construct() {
		parent::__construct();
	}
	function post_listAddPollAttribute() {
		global $reg_errors;
		$reg_errors = new WP_Error;
		$validation1 = new validation($reg_errors,array(),array('en'));
		$idfromUrl=$_GET["id"];
		$maxAttr = sanitize_text_field( (isset($_POST["maxAttr"])? $_POST["maxAttr"]:'') );
		$validation1->dynamicMultiLanguageInputForm($maxAttr);
		$reg_errors=$validation1->get_reg_errors();
		if( is_wp_error( $reg_errors ) && ! empty( $reg_errors->errors ) ) {		
	        require_once(ABSPATH . 'wp-admin/admin-header.php');
			require_once( plugin_dir_path( __FILE__ ) . "views/admin_updatepoll.php");
		}
		else {
			global $wpdb;
			$user = wp_get_current_user();
			$table_name2= $wpdb->prefix . TABLENAMEDETAIL;
			for ($y=0;$y<$maxAttr;$y++) {
	        	$text_default = sanitize_text_field(  (isset($_POST["attr$y-default"])? $_POST["attr$y-default"]:''));
	         	$text_en = sanitize_text_field(  (isset($_POST["attr$y-en"])? $_POST["attr$y-en"]:''));
	        	$wpdb->insert( $table_name2, 
		            array( 
		            	'table_master' => $idfromUrl,
		                'title_default' => $text_default,
		                'title_en' => $text_en,
		                'create_by' => $user->ID,
		                'vote' => '0',
		                'checked' => '0'
		            )
	        	);
	  		#echo "<pre>".$wpdb->last_query."</pre>";
	         }      
		}
		
		wp_redirect(admin_url().'admin.php?page=listPoll');
		
	}
	function get_listAddPollAttribute() {
		global $reg_errors;
		$maxAttr    = sanitize_text_field((isset($_GET["maxAttr"])? $_GET["maxAttr"]:'5'));
		$idfromUrl=$_GET["id"];
		require_once( plugin_dir_path( __FILE__ ) . "views/admin_addattributepoll.php");
	}

}

class Controller{
	#var $function_name_get,$function_name_post;
	function __construct() {
		$function_name_get = 'get_'.get_called_class();
		$function_name_post = 'post_'.get_called_class();
   		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   			if (method_exists(get_called_class(),$function_name_post)) {
   				$this->$function_name_post();
   			}
   			else {

   			}
   		}
   		else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
   			if (method_exists(get_called_class(),$function_name_get)) {
   				$this->$function_name_get();
   			}
   			else {

   			}
   		}
	}
}

class StringHelper {
	public static function returnTextForStatus($var) {
		if ($var == 1) {
			return 'Enable';
		}
		else {
			return 'Disable';
		}
	}



}



?>