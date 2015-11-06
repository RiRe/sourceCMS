<?php
$page = $_GET['p'];
if($page == "") $page = "startseite";
if($page_java != "") $page = $page_java;

if($page == "blog"){
	include("pages/blog.php");
} else if($page == "login"){
	include("pages/login.php");
} else if($page == "registrieren"){
	include("pages/registrieren.php");
} else if($page == "profil"){
	include("pages/profil.php");
} else if($page == "neue_seite"){
	include("pages/neue_seite.php");
} else if($page == "admin"){
	include("pages/admin.php");
} else {
	if(WARTUNG == 1 && $rights < 3){
		include("pages/wartung.php");
	} else if($rights < RIGHTS_NEEDED){
		include("pages/forbidden.php");
	} else {
		include("pages/standard.php");
	}
}
?>