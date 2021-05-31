<?php
class system{
	static function ago($timestamp){
		$time = strtotime($timestamp);
		$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");

		$now = time();

		// echo $now.'[]';
		// echo $time.'-';
		$difference = $now + 3600 - $time;
		// echo $difference.';';
		$tense = "ago";

		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if($difference != 1) {
			$periods[$j].= "s";
		}

		return "$difference $periods[$j] ago";
	}
}
?>
