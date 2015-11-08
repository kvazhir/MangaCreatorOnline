<?php
class response{

	private $res = array();
	private $success;
	private $cat;//:3

	function __construct($cat){//$cat not $type you germophobic crackhead.
		$this->cat = $cat;
		$this->success = true;
	}

	public function add($type, $text){
		$this->res[] = $text;
		if($type == 'error'){
			$this->success = false;
		} elseif($type == 'success'){
			$this->success = true;
		}
	}

	public function issuccessful(){
		return $this->success;
	}

	public function display(){
		$class = "error";
		if ($this->issuccessful())
			$class = "success";

		foreach($this->res as $text){
			?>
			<script type="text/javascript">
				var type = '<?php echo $class; ?>';
				var text = '<?php echo $text; ?>';
				if (type != "error")
					$.growl({ title: "Success", message: text });
				else
					$.growl.error({ title: "", message: text });
			</script>
			<?php
		}
	}
}
?>
