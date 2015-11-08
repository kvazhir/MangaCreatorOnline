<?php
class user{
	public $username;
	public $password;
	public $email;
	static $logged_in = false;
	static $current;
	public $status;
	public $avatar;
	public $id;
	public $register_date;

	function __construct($user){
		$mysql = mysql::get_instance();
		if(!is_array($user)){
			$get_id = "select * from users where id=".$mysql->real_escape($user);
			$mysql->query($get_id);
			$user = $mysql->fetch();
			//print_r($user);
		}
		$this->id = $user['id'];
		$this->username = $user['username'];
		$this->password = $user['password'];
		$this->email = $user['email'];
		$this->status = $user['status'];
		$this->register_date = $user['register'];
		$this->avatar = $user['avatar'];
	}

	static function register($user, $pass, $email){
		$mysql = mysql::get_instance();
		$response = new response('register');
		$sql_check = "select username,email from users where username ='".$mysql->real_escape($user)."' OR email = '".$mysql->real_escape($email)."'";
		$mysql->query($sql_check);
		if ($mysql->num_rows() > 0) {
		 	$response->add('error', '&#8860; Username/Email already exists.');
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$response->add('error', '(☞◣д◢)☞ Invalid mail. Σ(▼□▼メ)');
		}
		if (strlen($pass)<8) {
			$response->add('error', 'Password not long enough. o(╥﹏╥)o');
		} elseif(strlen($pass)>16) {
			$response->add('error', 'Password too long... ι(｀ロ´)ノ');
		}
		if (preg_match('/[^\w]/',$user)){
			$response->add('error', 'Password too qweqweg... ι(｀ロ´)ノ');
		}
		if (strlen($user)<4) {
			$response->add('error', '(oT-T)尸~~ Username not long enough.');
		} elseif(strlen($user)>16) {
			$response->add('error', 'Username too long... ⊙︿⊙');
		}
		if ($response->issuccessful()) {
			$sql_command = "insert into users(username,password,email) values('".$mysql->real_escape($user)."','".md5($mysql->real_escape($pass))."','".$mysql->real_escape($email)."')";
			$mysql->query($sql_command);
			$response->add('success', 'Registration complete. (⑅‾̥̥̥̥̥̑⌣‾̥̥̥̥̥̑⑅)');
		}

		return $response;
	}

	static function login($username, $password){
		$err = array();
		$auth = self::auth($username, $password);
		if ($auth[0]){
			self::$current = new user($auth[1]);
			$_SESSION['username'] = $auth[1]['username'];
			$_SESSION['id'] = $auth[1]['id'];
			$_SESSION['status'] = $auth[1]['status'];
			// echo $_SESSION['username'].' '.$_SESSION['id'];
			self::$logged_in = true;
			return array(true);
		}else{
			$err[] = 'Error 404, Username/password not found.';
			return array(false, $err);
		}
	}

	static function auth($username, $password){
		$mysql = mysql::get_instance();
		$mysql->query('select * from users where username="'.$mysql->real_escape($username).'" and password="'.md5($mysql->real_escape($password)).'"');
		if ($mysql->num_rows() == 0){
			return array(false);
		} else {
			return array(true, $mysql->fetch());
		}
	}

	static function autologin(){
		if(isset($_SESSION['id'])){
			self::$current = new user($_SESSION['id']);
			self::$logged_in = true;
		}
	}

	function convertImage($originalImage, $outputImage, $quality){
		// jpg, png, gif or bmp?
		$exploded = explode('.',$originalImage);
		$ext = $exploded[count($exploded) - 1];

		if (preg_match('/jpg|jpeg/i',$ext))
			$imageTmp = imagecreatefromjpeg($originalImage);
		else if (preg_match('/png/i',$ext))
			$imageTmp = imagecreatefrompng($originalImage);
		else if (preg_match('/gif/i',$ext))
			$imageTmp = imagecreatefromgif($originalImage);
		else if (preg_match('/bmp/i',$ext))
			$imageTmp = imagecreatefrombmp($originalImage);
		else
			return 0;

		// quality is a value from 0 (worst) to 100 (best)
		imagejpeg($imageTmp, $outputImage, $quality);
		imagedestroy($imageTmp);

		return 1;
	}

	function upload_avatar($files){
		$target_dir = $_SERVER['DOCUMENT_ROOT'].'/imagevault/uploaded/avatars/';
		// echo $target_dir.'<br>'.$files["fileToUpload"]["tmp_name"].'<Br>';
		// echo '<img src="'.$target_dir.'Ishimaru.jpg" />';
		$target_file = $target_dir . basename($files["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		$size = getimagesize($files["fileToUpload"]["tmp_name"]);
		// print_r($size);

		// echo $ratio;
		$ratio = $size[0] / $size[1];
		$ratio_200 = $size[1]/200;
		$height = ceil($size[1]/$ratio_200);
		$width = ceil($size[0]/$ratio_200);
		if($width > 300){
			$dif = $width - 300;
			$width -= $dif;
		}
		// if($ratio > 1) {
		// 	$height = ceil($size[1]/$ratio_200);
		// 	$width = ceil($size[0]/$ratio_200);
		// } else {
		// 	$height = ceil($size[1]/$ratio_200);
		// 	$width = ceil($size[0]/$ratio_200);
		// }
			// $width = 500;
			// $height = 500/$ratio;
		// echo $height.' '.$width;
		$src = imagecreatefromstring(file_get_contents($files["fileToUpload"]["tmp_name"]));
		$dst = imagecreatetruecolor($width,$height);
		imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
		imagedestroy($src);
		imagepng($dst,$files["fileToUpload"]["tmp_name"]); // adjust format as needed
		imagedestroy($dst);
		// $check !== false ? $uploadOk = 1 : $uploadOk = 0;
		// Check if file already exists
		// file_exists($target_file) && $uploadOk = 0;
		// echo $target_file;
		// print_r($files["fileToUpload"]);
		// $name = basename($files["fileToUpload"]["name"], '.png');
		// echo $name;
		unlink($target_dir.$_SESSION['id'].'.png');
		unlink($target_dir.$_SESSION['id'].'.jpg');
		unlink($target_dir.$_SESSION['id'].'.gif');
		unlink($target_dir.$_SESSION['id'].'.jpeg'); //EROORS

		// echo $_SESSION['id'];
		////////////////
		// $files["fileToUpload"]["size"] > 500000 && $uploadOk = 0;
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			$uploadOk = 0;
		}
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		} else {
			move_uploaded_file($files["fileToUpload"]["tmp_name"], $target_file);
			// $this->convertImage($files["fileToUpload"]["tmp_name"], $target_file, 100);
			rename($target_file, $target_dir.$_SESSION['id'].'.'.$imageFileType);
			return $_SESSION['id'].'.'.$imageFileType;
		}
	}
}
?>
