<?php
if(empty($_GET['p'])) $_GET['p'] = "startseite";

if($_GET['p'] == "blog" && BLOG == 1){
	include("pages/blog.php");
} else if($_GET['p'] == "login"){
	include("pages/login.php");
} else if($_GET['p'] == "registrieren"){
	include("pages/registrieren.php");
} else if($_GET['p'] == "profil"){
	include("pages/profil.php");
} else if($_GET['p'] == "neu"){
	include("pages/neu.php");
} else if($_GET['p'] == "admin"){
	include("pages/admin.php");
} else {
	if(WARTUNG == 1 && $rights < 3){
		$_GET['p'] = "wartung";
		include("pages/wartung.php");
	} else if($rights < RIGHTS_NEEDED){
		include("pages/forbidden.php");
	} else {
		include("pages/standard.php");
	}
}
?>