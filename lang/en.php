<?php

class ei_pollLocalization {
	public static $totalVote = "Total Votes: ";
	public static $vote = "vote(s)";
	public static $send = "Send";
	public static $viewResult = "View Results ";

	public static final function _output($keyword='xxx') {
		if (property_exists('ei_pollLocalization', $keyword)) {
			echo self::$$keyword;
		}
		
	}

}
?>	