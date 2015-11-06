<?php
error_reporting(0);

$host = "localhost"; // MySQL-Host
$user = "virtuasoft_cms"; // MySQL-Benutzer
$password = "LrSxytDttGc4nyXt"; // MySQL-Passwort
$database = "virtuasoft_cms"; // MySQL-Datenbank

// Ab hier bitte nichts mehr ändern

$startzeit = explode(" ", microtime());
$startzeit = $startzeit[0]+$startzeit[1];

mysql_connect($host,$user,$password) or die (mysql_error());
mysql_select_db($database) or die (mysql_error());

$sql = mysql_fetch_object(mysql_query("SELECT value FROM config WHERE `key` = 'debug' LIMIT 1"));
$debug = $sql->value;

if(mysql_num_rows(mysql_query("SELECT value FROM config WHERE `key` = 'debug' LIMIT 1")) == 0){

mysql_query("CREATE TABLE IF NOT EXISTS `blog` (
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `rights` int(1) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  PRIMARY KEY (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

mysql_query("CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

mysql_query("INSERT INTO `config` (`key`, `value`) VALUES
('auth', '1'),
('blog', '1'),
('debug', ''),
('javascript', '0'),
('rights_needed', '0'),
('sitename', 'virtuaCMS Demo'),
('template', 'default'),
('wartung', '0');");

mysql_query("CREATE TABLE IF NOT EXISTS `pages` (
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `rights` int(1) NOT NULL DEFAULT '0',
  `index` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

mysql_query("INSERT INTO `pages` (`slug`, `title`, `content`, `rights`, `index`) VALUES
('startseite', 'Startseite', '<p>Sie sehen hier Ihre Installation des Content Management Systems virtuaCMS.</p>\r\n\r\n<p>Ein Login ist mit folgenden Benutzernamen m&ouml;glich:</p>\r\n\r\n<ul>\r\n	<li>admin</li>\r\n	<li>autor</li>\r\n	<li>mitglied</li>\r\n	<li>benutzer</li>\r\n	<li>gesperrt</li>\r\n</ul>\r\n\r\n<p>Das Passwort lautet jeweils <strong>demo</strong>.</p>', 0, 0);
");

mysql_query("CREATE TABLE IF NOT EXISTS `statistics` (
  `day` varchar(255) NOT NULL,
  `visitors` int(255) NOT NULL DEFAULT '0',
  `sites` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`day`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

mysql_query("CREATE TABLE IF NOT EXISTS `users` (
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rights` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

mysql_query("INSERT INTO `users` (`user`, `password`, `rights`) VALUES
('admin', '7d6e974a8a466c3a07b98ca5370d2ed2', 4),
('autor', '7d6e974a8a466c3a07b98ca5370d2ed2', 3),
('benutzer', '7d6e974a8a466c3a07b98ca5370d2ed2', 1),
('gesperrt', '7d6e974a8a466c3a07b98ca5370d2ed2', 0),
('mitglied', '7d6e974a8a466c3a07b98ca5370d2ed2', 2);");

$debug = 0;
}

define('DEBUG',$debug);
if(DEBUG == 1) echo "DEBUG: Database connection etablished.";

$sql = mysql_fetch_object(mysql_query("SELECT value FROM config WHERE `key` = 'template' LIMIT 1"));
define('TEMPLATE',$sql->value);

$sql = mysql_fetch_object(mysql_query("SELECT value FROM config WHERE `key` = 'sitename' LIMIT 1"));
define('SITENAME',$sql->value);

$sql = mysql_fetch_object(mysql_query("SELECT value FROM config WHERE `key` = 'wartung' LIMIT 1"));
define('WARTUNG',$sql->value);

$sql = mysql_fetch_object(mysql_query("SELECT value FROM config WHERE `key` = 'blog' LIMIT 1"));
define('BLOG',$sql->value);

$sql = mysql_fetch_object(mysql_query("SELECT value FROM config WHERE `key` = 'auth' LIMIT 1"));
define('AUTH',$sql->value);

$sql = mysql_fetch_object(mysql_query("SELECT value FROM config WHERE `key` = 'javascript' LIMIT 1"));
define('JAVASCRIPT',$sql->value);

$sql = mysql_fetch_object(mysql_query("SELECT value FROM config WHERE `key` = 'rights_needed' LIMIT 1"));
define('RIGHTS_NEEDED',$sql->value);

session_start();

if($_GET['action'] == "logout"){
session_destroy();
$_SESSION['visited'] = 1;
setcookie('user','',0);
setcookie('password','',0);
if(JAVASCRIPT == 1){
header('Location: /');
exit;
}
}

function hash_password($password){
return md5(sha1(md5(sha1($password))));
}

if(!isset($_SESSION['user']) && isset($_COOKIE['user']) && isset($_COOKIE['password'])) login($_COOKIE['user'],$_COOKIE['password'],1);

function login($user, $password, $hashed = 0){
if($hashed != 1) $password = hash_password($password);
$sql = mysql_query("SELECT * FROM users WHERE user = '".$user."' AND password = '".$password."' AND rights > 0");
if(mysql_num_rows($sql) != 1){
	return false;
} else {
	$_SESSION['user'] = $user;
	$_SESSION['password'] = $password;
	return true;
}
}

function register($user, $password){
$password_hashed = hash_password($password);
mysql_query("INSERT INTO users (`user`,`password`) VALUES ('".mysql_real_escape_string($user)."','".mysql_real_escape_string($password_hashed)."')");
if(login($user,$password)){
	return true;
} else {
	return false;
}
}

if($_POST['action'] == "profile"){
	if($_POST['password'] != "" || $_POST['password2'] != ""){
		if($_POST['password'] == $_POST['password2']){
			mysql_query("UPDATE users SET password = '".hash_password($_POST['password'])."' WHERE user = '".$_SESSION['user']."' LIMIT 1");
			$_SESSION['password'] = hash_password($_POST['password']);
		} else {
			$error_profil = true;
		}
	}
	
	if($_POST['user'] != ""){
	if(mysql_query("UPDATE users SET user = '".mysql_real_escape_string($_POST['user'])."' WHERE user = '".$_SESSION['user']."' LIMIT 1") == true){
		$_SESSION['user'] = $_POST['user'];
	} else {
		$error_profil = true;
	}
	}
} else if($_POST['user'] && $_POST['password'] && $_POST['password2']){
	if($_POST['password'] == $_POST['password2']){
		if(!register($_POST['user'],$_POST['password'])) $error_reg = true;
		if($error_reg != true){
			header('Location: ./');
			exit;
		}
	} else {
		$error_reg = true;
	}
} else if($_POST['user'] && $_POST['password']){
	if(!login($_POST['user'],$_POST['password'])){
		$sql = mysql_fetch_object(mysql_query("SELECT * FROM users WHERE `user` = '".$_POST['user']."' AND `password` = '".hash_password($_POST['password'])."'"));
		$error_login = 1;
		if($sql->rights == 0 && $sql != false) $error_login = 2;
	} else {
			if($_POST['stayloggedin'] == "yes"){
				setcookie('user',$_POST['user'],(time()+(60*60*24*7)));
				setcookie('password',hash_password($_POST['password']),(time()+(60*60*24*7)));
			}
			header('Location: ./');
			exit;
	}
}

$sql = mysql_query("SELECT * FROM users WHERE user = '".$_SESSION['user']."' AND password = '".$_SESSION['password']."' LIMIT 1");
$user = mysql_fetch_object($sql);

$rights = 0;
if(isset($user->rights)) $rights = $user->rights;

if($_GET['action'] == "logout") $rights = 0;

mysql_query("INSERT INTO statistics (`day`) VALUES ('".date("d.m.Y")."')");
if($_SESSION['visited'] != date("d.m.Y")){
$_SESSION['visited'] = date("d.m.Y");
mysql_query("UPDATE statistics SET visitors = visitors + 1 WHERE day = '".date("d.m.Y")."' LIMIT 1");
}
mysql_query("UPDATE statistics SET sites = sites + 1 WHERE day = '".date("d.m.Y")."' LIMIT 1");

?>