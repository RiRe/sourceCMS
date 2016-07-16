<?php
if($_GET['p'] == "") $_GET['p'] = "startseite";
$display = 1;
if($_GET['a1'] == "delete" && $_GET['p'] != "startseite" && $rights >= 3){
	$db->query("DELETE FROM pages WHERE slug = '".$db->real_escape_string($_GET['p'])."' LIMIT 1");
	header('Location: ./');
	exit;
}
if($_GET['a1'] == "m" && $_GET['p'] != "startseite" && $rights >= 3) $db->query("UPDATE pages SET `index` = `index` - 1 WHERE slug = '".$db->real_escape_string($_GET['p'])."' LIMIT 1");
if($_GET['a1'] == "p" && $_GET['p'] != "startseite" && $rights >= 3) $db->query("UPDATE pages SET `index` = `index` + 1 WHERE slug = '".$db->real_escape_string($_GET['p'])."' LIMIT 1");
if(($_GET['a1'] == "m" || $_GET['a1'] == "p") && $_GET['p'] != "startseite" && $rights >= 3){
	header('Location: ./' . $_GET['p'] . '.html');
	exit;
}
$sql = $db->query("SELECT * FROM pages WHERE slug = '".$db->real_escape_string($_GET['p'])."' AND rights <= ".$rights);
if($sql->num_rows != 1){
	include("error.php");
} else {
	if($_POST['change'] == "yes" && $rights >= 3){
	if($_POST['title'] != "" && $_POST['content'] != "" && is_numeric($_POST['rights'])){
	$db->query("UPDATE pages SET content = '".$db->real_escape_string($_POST['content'])."', title = '".$db->real_escape_string($_POST['title'])."', rights = '".$db->real_escape_string($_POST['rights'])."' WHERE slug = '".$db->real_escape_string($_GET['p'])."' LIMIT 1");
	header('Location: ./' . $_GET['p'] . ".html");
	exit;
	} else {
	$display = 0;
?>
<div class="container" style="margin-top:25px">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1>Fehler</h1>
			</div>
Bitte f&uuml;llen Sie alle Felder aus und gehen Sie nun <a href=\"javascript:history.back()\">zur&uuml;ck</a>
		</div>
          </div>
        </div>
<?php
}
}
$sql = $db->query("SELECT * FROM pages WHERE slug = '".$db->real_escape_string($_GET['p'])."' AND rights <= ".$rights);
$page = $sql->fetch_object();
if($display == 1){
?>
<div class="container" style="margin-top:25px">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1><? echo $_GET['a1'] == "edit" && $rights >= 3 ? "Seite bearbeiten" : $page->title; ?> <?php if($rights >= 3 && $_GET['a1'] != "edit"){ ?><small><a href="./<?=$_GET['p']; ?>_edit.html">bearbeiten</a><?php if($page->slug != "startseite"){ ?> :: <a href="./<?=$_GET['p']; ?>_delete.html">l&ouml;schen</a> :: <a href="./<?=$_GET['p']; ?>_m.html">nach vorne</a> :: <a href="./<?=$_GET['p']; ?>_p.html">nach hinten</a><?php } ?></small><?php } ?></h1></div>
				<?php if($_GET['a1'] == "edit" && $rights >= 3){ ?>
				<form class="form-horizontal" method="POST" action="./<?=$_GET['p']; ?>.html">
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