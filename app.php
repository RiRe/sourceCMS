<?php
error_reporting(E_ERROR);

if(!file_exists(__DIR__ . "/db.php")){
	if(isset($_POST['host'])){
		$db = new MySQLi($_POST['host'], $_POST['user'], $_POST['password']);
		if(!$db->connect_errno && !empty($_POST['host']) && !empty($_POST['user']) && !empty($_POST['password'])){
			if(!$db->select_db($_POST['database'])){
				$db->query("CREATE DATABASE `" . $db->real_escape_string($_POST['database']) . "`;");
				if(!$db->select_db($_POST['database'])){
					$err = "Die Datenbank konnte nicht angelegt werden.";
				}
			}

			if(empty($_POST['database'])) $err = "Es wurde keine Datenbank angegeben.";

			if(empty($err)){
				if(!file_put_contents(__DIR__ . "/db.php", '<?php
$host = "' . str_replace('"', "'", $_POST['host']) . '"; // MySQL-Host
$user = "' . str_replace('"', "'", $_POST['user']) . '"; // MySQL-Benutzer
$password = "' . str_replace('"', "'", $_POST['password']) . '"; // MySQL-Passwort
$database = "' . str_replace('"', "'", $_POST['database']) . '"; // MySQL-Datenbank')){
					$err = "Die Konfigurationsdatei <i>db.php</i> konnte nicht angelegt werden.";
				} else {
					header('Location: ./');
					exit;
				}
			}
		} else {
			$err = "Verbindung konnte nicht aufgebaut werden.";
		}
	}

	?>
	<!DOCTYPE html>
	<html lang="de">
	  <head>
	    <title>Installation :: sourceCMS</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="utf-8">
	    <link rel="stylesheet" href="themes/default.css">
		<style>
		body {
			overflow-y: scroll;
		}
		</style>
	  </head>
	  <body>
	  	<div class="container">
	  		<div class="page-header"><h1>Installation <small>sourceCMS</small></h1></div>
	  		<p style="text-align: justify;">Bitte geben Sie hier Ihre Datenbank-Zugangsdaten ein. Die Datenbank muss nicht existieren, in diesem Fall ben&ouml;tigt der Benutzer jedoch die Rechte, sie anzulegen. Wenn Sie die Datenbank einer bestehenden sourceCMS-Installation w&auml;hlen, werden die bereits vorhandenen Daten aus dieser verwendet.</p>

	  		<?php if(isset($err)){ ?><div class="alert alert-danger"><?=$err; ?></div><?php } ?>

	  		<form method="POST" style="margin-top: 20px;">
	  			<div class="form-group">
	  				<label for="host">Datenbank-Host</label>
	  				<input type="text" name="host" id="host" value="<?=isset($_POST['host']) ? $_POST['host'] : "localhost"; ?>" placeholder="Meist localhost" class="form-control" />
	  			</div>

	  			<div class="form-group">
	  				<label for="user">Datenbank-Benutzer</label>
	  				<input type="text" name="user" id="user" value="<?=isset($_POST['user']) ? $_POST['user'] : ""; ?>" placeholder="root" class="form-control" />
	  			</div>

	  			<div class="form-group">
	  				<label for="password">Datenbank-Passwort</label>
	  				<input type="password" name="password" id="password" value="<?=isset($_POST['password']) ? $_POST['password'] : ""; ?>" placeholder="kQjKl01P" class="form-control" />
	  			</div>

	  			<div class="form-group">
	  				<label for="database">Datenbank-Name</label>
	  				<input type="text" name="database" id="database" value="<?=isset($_POST['database']) ? $_POST['database'] : ""; ?>" placeholder="cms" class="form-control" />
	  			</div>

	  			<input type="submit" class="btn btn-primary btn-block" value="Daten pr&uuml;fen" />
	  		</form>
	  	</div>
	  </body>
	</html>
	<?php
	exit;
}

require __DIR__ . "/db.php";
$db = new MySQLi($host, $user, $password);
if($db->connect_errno) die("MySQLi-Fehler: <i>{$db->connect_error}</i>");

if(!$db->select_db($database)){
	$db->query("CREATE DATABASE `" . $db->real_escape_string($database) . "`;");
	if(!$db->select_db($database)) die("MySQLi-Fehler: <i>Datenbank nicht vorhanden.</i>");
}

if($db->query("SELECT value FROM config WHERE `key` = 'blog' LIMIT 1")->num_rows == 0){
	$db->query("CREATE TABLE IF NOT EXISTS `blog` (
	  `title` varchar(255) NOT NULL,
	  `content` longtext NOT NULL,
	  `rights` int(1) NOT NULL DEFAULT '0',
	  `date` int(11) NOT NULL,
	  PRIMARY KEY (`title`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

	$db->query("CREATE TABLE IF NOT EXISTS `config` (
	  `key` varchar(255) NOT NULL,
	  `value` varchar(255) NOT NULL,
	  PRIMARY KEY (`key`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

	$db->query("INSERT INTO `config` (`key`, `value`) VALUES
	('auth', '1'),
	('blog', '1'),
	('rights_needed', '0'),
	('sitename', 'sourceCMS'),
	('template', 'default'),
	('wartung', '0');");

	$db->query("CREATE TABLE IF NOT EXISTS `pages` (
	  `slug` varchar(255) NOT NULL,
	  `title` varchar(255) NOT NULL,
	  `content` longtext NOT NULL,
	  `rights` int(1) NOT NULL DEFAULT '0',
	  `index` int(11) NOT NULL DEFAULT '0',
	  PRIMARY KEY (`slug`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

	$db->query("INSERT INTO `pages` (`slug`, `title`, `content`, `rights`, `index`) VALUES
	('startseite', 'Startseite', '<p>Sie sehen hier Ihre Installation des Content Management Systems sourceCMS.</p>\r\n\r\n<p>Ein Login ist mit dem Benutzernamen <b>admin</b> und dem Passwort <b>admin</b> m&ouml;glich.</p>', 0, 0);
	");

	$db->query("CREATE TABLE IF NOT EXISTS `statistics` (
	  `day` varchar(255) NOT NULL,
	  `visitors` int(255) NOT NULL DEFAULT '0',
	  `sites` int(255) NOT NULL DEFAULT '0',
	  PRIMARY KEY (`day`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

	$db->query("CREATE TABLE IF NOT EXISTS `users` (
	  `user` varchar(255) NOT NULL,
	  `password` varchar(255) NOT NULL,
	  `rights` int(1) NOT NULL DEFAULT '1',
	  PRIMARY KEY (`user`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

	$db->query("INSERT INTO `users` (`user`, `password`, `rights`) VALUES
	('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 4);");
}

$sql = $db->query("SELECT value FROM config WHERE `key` = 'template' LIMIT 1")->fetch_object();
define('TEMPLATE',$sql->value);

$sql = $db->query("SELECT value FROM config WHERE `key` = 'sitename' LIMIT 1")->fetch_object();
define('SITENAME',$sql->value);

$sql = $db->query("SELECT value FROM config WHERE `key` = 'wartung' LIMIT 1")->fetch_object();
define('WARTUNG',$sql->value);

$sql = $db->query("SELECT value FROM config WHERE `key` = 'blog' LIMIT 1")->fetch_object();
define('BLOG',$sql->value);

$sql = $db->query("SELECT value FROM config WHERE `key` = 'auth' LIMIT 1")->fetch_object();
define('AUTH',$sql->value);

$sql = $db->query("SELECT value FROM config WHERE `key` = 'rights_needed' LIMIT 1")->fetch_object();
define('RIGHTS_NEEDED',$sql->value);

session_start();

if(isset($_GET['p']) && $_GET['p'] == "logout"){
	session_destroy();
	$_SESSION['visited'] = 1;
	setcookie('user', '', 0);
	setcookie('password', '', 0);
	
	header('Location: ./');
	exit;
}

function hash_password($password){
	return hash("sha256", $password);
}

if(!isset($_SESSION['user']) && isset($_COOKIE['user']) && isset($_COOKIE['password'])) login($_COOKIE['user'], $_COOKIE['password'], 1);

function login($user, $password, $hashed = 0){
	global $db;

	if($hashed != 1) $password = hash_password($password);
	$sql = $db->query("SELECT * FROM users WHERE user = '" . $db->real_escape_string($user) . "' AND password = '" . $db->real_escape_string($password) . "' AND rights > 0");
	if($sql->num_rows != 1){
		return false;
	} else {
		$_SESSION['user'] = $user;
		$_SESSION['password'] = $password;
		return true;
	}
}

function register($user, $password){
	global $db;

	$password_hashed = hash_password($password);
	$db->query("INSERT INTO users (`user`,`password`) VALUES ('".$db->real_escape_string($user)."','".$db->real_escape_string($password_hashed)."')");
	if(login($user,$password)){
		return true;
	} else {
		return false;
	}
}

if($_POST['action'] == "profile"){
	if($_POST['password'] != "" || $_POST['password2'] != ""){
		if($_POST['password'] == $_POST['password2']){
			$db->query("UPDATE users SET password = '".hash_password($_POST['password'])."' WHERE user = '".$_SESSION['user']."' LIMIT 1");
			$_SESSION['password'] = hash_password($_POST['password']);
		} else {
			$error_profil = true;
		}
	}
	
	if($_POST['user'] != ""){
		if($db->query("UPDATE users SET user = '".$db->real_escape_string($_POST['user'])."' WHERE user = '".$_SESSION['user']."' LIMIT 1") == true){
			$_SESSION['user'] = $_POST['user'];
		} else {
			$error_profil = true;
		}
	}
} else if($_POST['user'] && $_POST['password'] && $_POST['password2']){
	if($_POST['password'] == $_POST['password2']){
		if(!register($_POST['user'],$_POST['password'])){
			$error_reg = true;
		} else {
			header('Location: ./');
			exit;
		}
	} else {
		$error_reg = true;
	}
} else if($_POST['user'] && $_POST['password']){
	if(!login($_POST['user'],$_POST['password'])){
		$sql = $db->query("SELECT * FROM users WHERE `user` = '".$db->real_escape_string($_POST['user'])."' AND `password` = '".hash_password($_POST['password'])."'")->fetch_object();
		$error_login = 1;
		if(isset($sql->rights) && $sql->rights == 0 && $sql !== false) $error_login = 2;
	} else {
		if($_POST['stayloggedin'] == "yes"){
			setcookie('user',$_POST['user'],(time()+(60*60*24*7)));
			setcookie('password',hash_password($_POST['password']),(time()+(60*60*24*7)));
		}
		header('Location: ./');
		exit;
	}
}

$sql = $db->query("SELECT * FROM users WHERE user = '".$_SESSION['user']."' AND password = '".$_SESSION['password']."' LIMIT 1");
$user = $sql->fetch_object();

$rights = 0;
if(isset($user->rights)) $rights = $user->rights;

if(isset($_GET['p']) && $_GET['p'] == "logout") $rights = 0;

$db->query("INSERT INTO statistics (`day`) VALUES ('".date("d.m.Y")."')");
if($_SESSION['visited'] != date("d.m.Y")){
	$_SESSION['visited'] = date("d.m.Y");
	$db->query("UPDATE statistics SET visitors = visitors + 1 WHERE day = '".date("d.m.Y")."' LIMIT 1");
}
$db->query("UPDATE statistics SET sites = sites + 1 WHERE day = '".date("d.m.Y")."' LIMIT 1");

?>