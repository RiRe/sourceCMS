<?php
if($_GET['p'] == "") $_GET['p'] = "startseite";
$display = 1;
if($_GET['action'] == "delete" && $_GET['p'] != "startseite" && $rights >= 3){
mysql_query("DELETE FROM pages WHERE slug = '".mysql_real_escape_string($_GET['p'])."' LIMIT 1");
header('Location: ./');
exit;
}
if($_GET['action'] == "vor" && $_GET['p'] != "startseite" && $rights >= 3) mysql_query("UPDATE pages SET `index` = `index` - 1 WHERE slug = '".mysql_real_escape_string($_GET['p'])."' LIMIT 1");
if($_GET['action'] == "hinter" && $_GET['p'] != "startseite" && $rights >= 3) mysql_query("UPDATE pages SET `index` = `index` + 1 WHERE slug = '".mysql_real_escape_string($_GET['p'])."' LIMIT 1");
if(($_GET['action'] == "hinter" || $_GET['action'] == "vor") && $_GET['p'] != "startseite" && $rights >= 3){
header('Location: ./?p='.$_GET['p']);
exit;
}
$sql = mysql_query("SELECT * FROM pages WHERE slug = '".mysql_real_escape_string($_GET['p'])."' AND rights <= ".$rights);
if(mysql_num_rows($sql) != 1){
	include("error.php");
} else {
if($_POST['change'] == "yes" && $rights >= 3){
if($_POST['title'] != "" && $_POST['content'] != "" && is_numeric($_POST['rights'])){
mysql_query("UPDATE pages SET content = '".mysql_real_escape_string($_POST['content'])."', title = '".mysql_real_escape_string($_POST['title'])."', rights = '".mysql_real_escape_string($_POST['rights'])."' WHERE slug = '".mysql_real_escape_string($_GET['p'])."' LIMIT 1");
} else {
$display = 0;
?>
<div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1 id="type">Fehler</h1>
			<?php
echo "Bitte f&uuml;llen Sie alle Felder aus und gehen Sie nun <a href=\"javascript:history.back()\">zur&uuml;ck</a>.";
?>
		</div>
          </div>
        </div>
		</div>
<?php
}
}
$sql = mysql_query("SELECT * FROM pages WHERE slug = '".mysql_real_escape_string($_GET['p'])."' AND rights <= ".$rights);
$page = mysql_fetch_object($sql);
if($display == 1){
?>
<div class="container" style="margin-top:25px"><div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1 id="type"><? echo $_GET['action'] == "edit" && $rights >= 3 ? "Seite bearbeiten" : $page->title; ?> <?php if($rights >= 3 && $_GET['action'] != "edit"){ ?><small><a href="?p=<?=$_GET['p']; ?>&action=edit">bearbeiten</a><?php if($page->slug != "startseite"){ ?> :: <a href="?p=<?=$_GET['p']; ?>&action=delete">l&ouml;schen</a> :: <a href="?p=<?=$_GET['p']; ?>&action=vor">nach vorne</a> :: <a href="?p=<?=$_GET['p']; ?>&action=hinter">nach hinten</a><?php } ?></small><?php } ?></h1>
				<?php if($_GET['action'] == "edit" && $rights >= 3){ ?>
				<form class="form-horizontal" method="POST" action="?p=<?=$_GET['p']; ?>">
				<fieldset>
				<input type="text" name="title" placeholder="Titel" value="<?=$page->title; ?>" class="form-control"><br />
				<textarea class="ckeditor" name="content"><?=$page->content; ?></textarea><br />
				<select name="rights" class="form-control">
				<option value="0" <?php if($page->rights == 0) echo "SELECTED"; ?>>Zugriff f&uuml;r alle</option>
				<option value="1" <?php if($page->rights == 1) echo "SELECTED"; ?>>Zugriff nur f&uuml;r registrierte Benutzer + alle &uuml;bergeordneten Gruppen</option>
				<option value="2" <?php if($page->rights == 2) echo "SELECTED"; ?>>Zugriff nur f&uuml;r Mitglieder (Freischaltung erforderlich) + alle &uuml;bergeordneten Gruppen</option>
				<option value="3" <?php if($page->rights == 3) echo "SELECTED"; ?>>Zugriff nur f&uuml;r Autoren + alle &uuml;bergeordneten Gruppen</option>
				<option value="4" <?php if($page->rights == 4) echo "SELECTED"; ?>>Zugriff nur f&uuml;r Administratoren</option>
				</select><br />
				<input type="hidden" name="change" value="yes">
				<button type="submit" class="btn btn-success">Speichern</button>
				</fieldset>
				</form>
				<?php } else { ?>
				<?=$page->content; ?>
				<?php } ?>
			</div>
          </div>
        </div>
		</div>
		<?php } } ?>