<?php
class ei_pollLocalization {
	public static $totalVote = "Jumlah Undi: ";
	public static $viewResult = "Lihat Keputusan ";
	public static $vote = "undi";
	public static $send = "Hantar";

	public static final function _output($keyword='xxx') {
		if (property_exists('ei_pollLocalization', $keyword)) {
			echo self::$$keyword;
		}
		
	}

}
?>	