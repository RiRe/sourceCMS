<script type="text/javascript">
function show_tab(e){
document.getElementById('li_startseite').setAttribute("class","");
document.getElementById('content_startseite').style = "display:none";
<?php if(BLOG == 1){ ?>document.getElementById('li_blog').setAttribute("class","");
document.getElementById('content_blog').style = "display:none";<?php } ?>
<?php if($rights == 0){ ?>

document.getElementById('li_login').setAttribute("class","");
document.getElementById('content_login').style = "display:none";
<?php } ?><?php if(AUTH == 1 && $rights == 0){ ?>document.getElementById('li_registrieren').setAttribute("class","");
document.getElementById('content_registrieren').style = "display:none";<?php } ?>
<?php if($rights >= 3){ ?>document.getElementById('li_neue_seite').setAttribute("class","");document.getElementById('content_neue_seite').style = "display:none";<?php } ?>
<?php if($rights == 4){ ?>document.getElementById('li_admin').setAttribute("class","");document.getElementById('content_admin').style = "display:none";<?php } ?>
<?php if($rights > 0){ ?>document.getElementById('li_profil').setAttribute("class","");document.getElementById('content_profil').style = "display:none";<?php } ?>
<?php
if(WARTUNG != 1 || $rights >= 3){
$sql = mysql_query("SELECT * FROM pages WHERE slug != 'startseite' AND rights <= ".$rights." ORDER BY `index` ASC");
while($row = mysql_fetch_object($sql)){
?>
document.getElementById('li_<?=$row->slug; ?>').setAttribute("class","");
document.getElementById('content_<?=$row->slug; ?>').style = "display:none";
<?php } } ?>


document.getElementById('li_' + e).setAttribute("class","active");
document.getElementById('content_' + e).style = "display:block";
}


document.write("<div class=\"navbar navbar-default navbar-fixed-top\">");
document.write("      <div class=\"container\">");
document.write("        <div class=\"navbar-header\">");
document.write("          <a href=\"javascript:show_tab('startseite')\" class=\"navbar-brand\"><?=SITENAME; ?><\/a>");
document.write("          <button class=\"navbar-toggle\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbar-main\">");
document.write("            <span class=\"icon-bar\"><\/span>");
document.write("            <span class=\"icon-bar\"><\/span>");
document.write("            <span class=\"icon-bar\"><\/span>");
document.write("          <\/button>");
document.write("        <\/div>");
document.write("        <div class=\"navbar-collapse collapse\" id=\"navbar-main\">");
document.write("          <ul class=\"nav navbar-nav\">");
document.write("            <li id=\"li_startseite\" class=\"active\">");
document.write("              <a href=\"javascript:show_tab('startseite')\"><?php echo WARTUNG == 1 && $rights < 3 ? "Wartungsmodus" : "Startseite"; ?><\/a>");
document.write("            <\/li>");
<?php
if(WARTUNG != 1 || $rights >= 3){
$sql = mysql_query("SELECT * FROM pages WHERE slug != 'startseite' AND rights <= ".$rights." ORDER BY `index` ASC");
while($row = mysql_fetch_object($sql)){
?>
document.write("            <li id=\"li_<?=$row->slug; ?>\">");
document.write("              <a href=\"javascript:show_tab('<?=$row->slug; ?>')\"><?=$row->title; ?><\/a>");
document.write("            <\/li>");
<?php
}
}
?>
<?php if(BLOG == 1){ ?>
document.write("            <li id=\"li_blog\">");
document.write("              <a href=\"javascript:show_tab('blog')\">Blog<\/a>");
document.write("            <\/li>");
<?php } ?>
<?php if($rights >= 3){ ?>
document.write("            <li id=\"li_neue_seite\"><a href=\"javascript:show_tab('neue_seite')\">+<\/a><\/li>");
<?php } ?>
document.write("          <\/ul>");
document.write("          <ul class=\"nav navbar-nav navbar-right\">");
<?php if($rights > 0){ ?>
 <?php if($rights >= 4){  ?>
document.write("            <li id=\"li_admin\"><a href=\"javascript:show_tab('admin')\">Administration<\/a><\/li>");
   <?php } ?>
  
document.write("            <li id=\"li_profil\"><a href=\"javascript:show_tab('profil')\"><?=$_SESSION['user']; ?><\/a><\/li>");

document.write("            <li><a href=\"?p=<?=$_GET['p']; ?>&action=logout\">Ausloggen<\/a><\/li>");
<?php } else { ?>
document.write("            <li id=\"li_login\"><a href=\"javascript:show_tab('login')\">Login<\/a><\/li>");
<?php if(AUTH == 1){ ?>
document.write("            <li id=\"li_registrieren\"><a href=\"javascript:show_tab('registrieren')\">Registrieren<\/a><\/li>");
<?php } } ?>
document.write("          <\/ul>");
document.write("        <\/div>");
document.write("      <\/div>");
document.write("    <\/div>");
</script>

<noscript><?php include("menu.php"); ?></noscript>