<?php


class validation {
	function __construct($reg_errors,$multiLanguageInputForm=array(),$langs=array(),$dynamicMultiLanguageInputForm=1) {
		$this->reg_errors=$reg_errors;
		
		$this->multiLanguageInputForm=$multiLanguageInputForm;
		$this->langs=$langs;
	}
	function multiLanguageInputForm() {
		foreach ($this->multiLanguageInputForm as $key => $value)  {
			if (method_exists($this,$value)) {
				foreach ($this->langs as $lang) {
					$name_attr=$key."-".$lang;
					$this->$value($name_attr,$_POST[$name_attr]);
				}
				$name_attr=$key."-default";
				$this->$value($name_attr,$_POST[$name_attr]);
			}
		}
	}
	function dynamicMultiLanguageInputForm($var) {
		
		for ($x=0;$x<$var;$x++) {
			foreach ($this->langs as $lang) {
				$name_attr="attr".$x."-".$lang;
				$this->check_empty_text($name_attr,$_POST[$name_attr]);
			}
			$name_attr="attr".$x."-default";
			$this->check_empty_text($name_attr,$_POST[$name_attr]);
		}
	}
	protected function check_empty_text($key="",$value="") {
		if ( empty( $value)) {
			$this->reg_errors->add($key, "Required form field [$key] is missing");
		}
	}
	function get_reg_errors() {
		return $this->reg_errors;
	}
	

}

/*
if ( empty( $title_default )) {
		$reg_errors->add('title_default', 'Required form field [TITLE] is missing');
	}
	if ( empty( $title_en )) {
		$reg_errors->add('title_en', 'Required form field [TITLE] is missing');
	}
	if ( 4 > strlen( $name ) ) {
		$reg_errors->add( 'name', 'NAME too short. At least 4 characters is required' );
	}
	if ( empty( $subject ))  {
		$reg_errors->add('subject', 'Required form field [SUBJECT] is missing');
	}
	if ( empty( $email )) {
		$reg_errors->add('email', 'Required form field [EMAIL] is missing');
	}
	if ( !is_email( $email ) ) {
		$reg_errors->add( 'email', 'Email is not valid' );
	}	
*/
?>