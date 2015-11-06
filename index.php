<?php
include("functions.php");

$fileEnding = ".php";
if(JAVASCRIPT == 1) $fileEnding = "_java.php";

include('content/header.php');
include('content/menu'.$fileEnding);
include('content/content'.$fileEnding);
include('content/footer.php');
?>