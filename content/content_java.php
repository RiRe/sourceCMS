<script type="text/javascript">
document.write("<div id=\"content_startseite\" style=\"display: block;\">");
<?php
$page_java = 'startseite';
ob_start();
include("content.php");
$var[$page_java]=ob_get_contents();
ob_end_clean();
$var[$page_java] = str_replace("\r\n", "", $var[$page_java]);
$var[$page_java] = str_replace("\r", "", $var[$page_java]);
$var[$page_java] = str_replace("\n", "", $var[$page_java]);
$var[$page_java] = str_replace('"', '\"', $var[$page_java]);
$var[$page_java] = str_replace('/', '\/', $var[$page_java]);
?>
document.write("<?=$var[$page_java]; ?>");
document.write("<\/div>");
document.write("<\/div>");
document.write("<div id=\"content_blog\" style=\"display: none;\">");
<?php
$page_java = 'blog';
ob_start();
include("content.php");
$var[$page_java]=ob_get_contents();
ob_end_clean();
$var[$page_java] = str_replace("\r\n", "", $var[$page_java]);
$var[$page_java] = str_replace("\r", "", $var[$page_java]);
$var[$page_java] = str_replace("\n", "", $var[$page_java]);
$var[$page_java] = str_replace('"', '\"', $var[$page_java]);
$var[$page_java] = str_replace('/', '\/', $var[$page_java]);
?>
document.write("<?=$var[$page_java]; ?>");
document.write("<\/div>");
document.write("<\/div>");
document.write("<div id=\"content_neue_seite\" style=\"display: none;\">");
<?php
$page_java = 'neue_seite';
ob_start();
include("content.php");
$var[$page_java]=ob_get_contents();
ob_end_clean();
$var[$page_java] = str_replace("\r\n", "", $var[$page_java]);
$var[$page_java] = str_replace("\r", "", $var[$page_java]);
$var[$page_java] = str_replace("\n", "", $var[$page_java]);
$var[$page_java] = str_replace('"', '\"', $var[$page_java]);
$var[$page_java] = str_replace('/', '\/', $var[$page_java]);
?>
document.write("<?=$var[$page_java]; ?>");
document.write("<\/div>");
document.write("<\/div>");
document.write("<div id=\"content_admin\" style=\"display: none;\">");
<?php
$page_java = 'admin';
ob_start();
include("content.php");
$var[$page_java]=ob_get_contents();
ob_end_clean();
$var[$page_java] = str_replace("\r\n", "", $var[$page_java]);
$var[$page_java] = str_replace("\r", "", $var[$page_java]);
$var[$page_java] = str_replace("\n", "", $var[$page_java]);
$var[$page_java] = str_replace('"', '\"', $var[$page_java]);
$var[$page_java] = str_replace('/', '\/', $var[$page_java]);
?>
document.write("<?=$var[$page_java]; ?>");
document.write("<\/div>");
document.write("<\/div>");
document.write("<div id=\"content_profil\" style=\"display: none;\">");
<?php
$page_java = 'profil';
ob_start();
include("content.php");
$var[$page_java]=ob_get_contents();
ob_end_clean();
$var[$page_java] = str_replace("\r\n", "", $var[$page_java]);
$var[$page_java] = str_replace("\r", "", $var[$page_java]);
$var[$page_java] = str_replace("\n", "", $var[$page_java]);
$var[$page_java] = str_replace('"', '\"', $var[$page_java]);
$var[$page_java] = str_replace('/', '\/', $var[$page_java]);
?>
document.write("<?=$var[$page_java]; ?>");
document.write("<\/div>");
document.write("<\/div>");
document.write("<div id=\"content_login\" style=\"display: none;\">");
<?php
$page_java = 'login';
ob_start();
include("content.php");
$var[$page_java]=ob_get_contents();
ob_end_clean();
$var[$page_java] = str_replace("\r\n", "", $var[$page_java]);
$var[$page_java] = str_replace("\r", "", $var[$page_java]);
$var[$page_java] = str_replace("\n", "", $var[$page_java]);
$var[$page_java] = str_replace('"', '\"', $var[$page_java]);
$var[$page_java] = str_replace('/', '\/', $var[$page_java]);
?>
document.write("<?=$var[$page_java]; ?>");
document.write("<\/div>");
document.write("<\/div>");
document.write("<div id=\"content_registrieren\" style=\"display: none;\">");
<?php
$page_java = 'registrieren';
ob_start();
include("content.php");
$var[$page_java]=ob_get_contents();
ob_end_clean();
$var[$page_java] = str_replace("\r\n", "", $var[$page_java]);
$var[$page_java] = str_replace("\r", "", $var[$page_java]);
$var[$page_java] = str_replace("\n", "", $var[$page_java]);
$var[$page_java] = str_replace('"', '\"', $var[$page_java]);
$var[$page_java] = str_replace('/', '\/', $var[$page_java]);
?>
document.write("<?=$var[$page_java]; ?>");
document.write("<\/div>");
document.write("<\/div>");
<?php
if(WARTUNG != 1 || $rights >= 3){
$content[] = Array();
$sql = mysql_query("SELECT * FROM pages WHERE `slug` != 'startseite' AND `rights` <= ".$rights);

while($row = mysql_fetch_object($sql)){
$var[$page_java] = $row->content;
$var[$page_java] = str_replace("\r\n", "", $var[$page_java]);
$var[$page_java] = str_replace("\r", "", $var[$page_java]);
$var[$page_java] = str_replace("\n", "", $var[$page_java]);
$var[$page_java] = str_replace('"', '\"', $var[$page_java]);
$var[$page_java] = str_replace('/', '\/', $var[$page_java]);
$row->content = $var[$page_java];
?>
document.write("<div id=\"content_<?=$row->slug; ?>\" style=\"display: none;\">");

document.write(" <div class=\"container\" style=\"margin-top:25px\"><div class=\"bs-docs-section\"> "); 
document.write("         <div class=\"row\"> "); 
document.write("           <div class=\"col-lg-12\"> "); 
document.write("             <div class=\"page-header\"> ");
document.write("<h1 id=\"type\"><? echo $_GET['action'] == "edit" && $rights >= 3 ? "Seite bearbeiten" : $row->title; ?> <?php if($rights >= 3 && $_GET['action'] != "edit"){ ?><small><a href=\"?p=<?=$row->slug; ?>&action=edit\">bearbeiten</a><?php if($row->slug != "startseite"){ ?> :: <a href=\"?p=<?=$row->slug; ?>&action=delete\">l&ouml;schen</a> :: <a href=\"?p=<?=$row->slug; ?>&action=vor\">nach vorne</a> :: <a href=\"?p=<?=$row->slug; ?>&action=hinter\">nach hinten</a><?php } ?></small><?php } ?></h1>");
document.write("<?=$row->content; ?>");
document.write("<\/div>");
document.write("<\/div>");
document.write("<\/div>");
document.write("<\/div>");

document.write("<\/div>");
document.write("<\/div>");
<?php
}
}
?>
</script>

<noscript><?php include("content.php"); ?></noscript>