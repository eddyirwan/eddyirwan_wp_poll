<?php


function frontend($atts) {

    ob_start();
    $fe = new frontend($atts);
    $fe->loadLanguageClass($atts);
    $fe->question();
    return ob_get_clean();
}

function ei_voteThruAjax() {
    
    $fe = new frontend();
    $fe->loadLanguageClassFromAjaxCall(sanitize_text_field($_REQUEST['lang']));
    $fe->answer();
    $fe->publishResultPage();
    die();
}
function ei_seeResultFromAjax() {
    $fe = new frontend();
    $fe->loadLanguageClassFromAjaxCall(sanitize_text_field($_REQUEST['lang']));
    $fe->publishResultPage();
    die();
}

class frontend {
    function __construct($atts=array()) {
        global $wpdb;
        $this->table_name1 = $wpdb->prefix . TABLENAMEMASTER;
        $this->table_name2 = $wpdb->prefix . TABLENAMEDETAIL;
        $this->lang = "default";
    }
    

    function answer() {
        global $wpdb;
        if ( isset($_REQUEST) ) {
            $pollId = sanitize_text_field($_REQUEST['idOfButtonThatUserClick']);
            $table_name = $wpdb->prefix . TABLENAMEDETAIL;
            $sql="SELECT vote FROM $this->table_name2 where id = $pollId";
            $curr_vote=$wpdb->get_var( $sql );
            $curr_vote=$curr_vote+1;
            $updated = $wpdb->update("$this->table_name2", array(
                'vote'=>$curr_vote),
                array(
                    'id'=>$pollId
            ));
        }
    }
    public function publishResultPage() {
        global $wpdb;
        extract($this->_readDb());
        require_once( plugin_dir_path( __FILE__ ) . "views".DIRECTORY_SEPARATOR."results.php");
    }

    public static function calculate($currVote,$totalVote) {
        return round(($currVote / $totalVote)*100);
    }

    protected function _readDb() {
        global $wpdb;
        $sql1="SELECT * FROM $this->table_name1 WHERE status = 1 LIMIT 1";
        $rows1 = $wpdb->get_results($sql1);
        $id=0;
        $x=0;
        $title="NONE";
        $rows2=array();
        $totalVote=0;
        foreach ($rows1 as $row1) {
            $id=$row1->id;
            if ($this->lang == "default") {
                $title=$row1->title_default; 
            }
            else {
                $lang='title_'.$this->lang;
                $title=$row1->$lang; 
            }
            $sql2="SELECT * FROM $this->table_name2 WHERE `table_master` = $row1->id";
            $rows2 = $wpdb->get_results($sql2);
            foreach ($rows2 as $row2) {
                $totalVote=$totalVote+$row2->vote;
            }
        }
        return array(
            'id'=>$id,
            'title'=>$title,
            'rows2'=>$rows2,
            'x'=>$x,
            'totalVote'=>$totalVote,
        );
    }
    public function question() {
        global $wpdb;
        extract($this->_readDb());
        require_once( plugin_dir_path( __FILE__ ) . "views".DIRECTORY_SEPARATOR."polls.php");

    }
    public function loadLanguageClassFromAjaxCall($lang) {
        if ($lang == "") {
            require_once( plugin_dir_path( __FILE__ ) . "lang".DIRECTORY_SEPARATOR."default.php");
            $this->lang = "default";
        }
        else {
            require_once( plugin_dir_path( __FILE__ ) . "lang".DIRECTORY_SEPARATOR.$lang.".php");
            $this->lang = "$lang";
        }
    }
    public function loadLanguageClass($atts) {
        if (array_key_exists('lang',$atts)) {
            require_once( plugin_dir_path( __FILE__ ) . "lang".DIRECTORY_SEPARATOR.$atts['lang'].".php");
            $this->lang=$atts['lang']; 
        }
        else {
            require_once( plugin_dir_path( __FILE__ ) . "lang".DIRECTORY_SEPARATOR."default.php"); 
            $this->lang = "default";
        }
    }

}

?>