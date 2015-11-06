<?php
$display = 1;

if(WARTUNG == 1 && $rights < 3){
include("wartung.php");
} else if ($rights < RIGHTS_NEEDED) {
include("forbidden.php");
} else {
if($rights >= 3 && $_GET['action'] == "delete") mysql_query("DELETE FROM blog WHERE title = '".mysql_real_escape_string(urldecode($_GET['entry']))."' AND rights <= ".$rights." LIMIT 1");

if($rights >= 3 && $_GET['edit'] == "do"){
if($_POST['title'] != "" && $_POST['content'] != "" && is_numeric($_POST['rights'])){
mysql_query("UPDATE blog SET title = '".mysql_real_escape_string($_POST['title'])."', content = '".mysql_real_escape_string($_POST['content'])."', rights = '".mysql_real_escape_string($_POST['rights'])."' WHERE title = '".mysql_real_escape_string(urldecode($_GET['entry']))."' LIMIT 1");
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


if($rights >= 3 && $_GET['action'] == "edit" && $_GET['entry'] != ""){
$sql = mysql_query("SELECT * FROM blog WHERE title = '".mysql_real_escape_string(urldecode($_GET['entry']))."' AND rights <= ".$rights);
if(mysql_num_rows($sql) == 1){
$display = 0;
$entry = mysql_fetch_object($sql);
?>
<div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1 id="type">Beitrag bearbeiten</h1>
<form class="form-horizontal" method="POST" action="?p=blog&entry=<?=$_GET['entry']; ?>&edit=do">
				<fieldset>
				<input type="text" name="title" placeholder="Titel" value="<?=$entry->title; ?>" class="form-control"><br />
				<textarea class="ckeditor" name="content"><?=$entry->content; ?></textarea><br />
				<select name="rights" class="form-control">
				<option value="0" <?php if($entry->rights == 0) echo "SELECTED"; ?>>Zugriff f&uuml;r alle</option>
				<option value="1" <?php if($entry->rights == 1) echo "SELECTED"; ?>>Zugriff nur f&uuml;r registrierte Benutzer + alle &uuml;bergeordneten Gruppen</option>
				<option value="2" <?php if($entry->rights == 2) echo "SELECTED"; ?>>Zugriff nur f&uuml;r Mitglieder (Freischaltung erforderlich) + alle &uuml;bergeordneten Gruppen</option>
				<option value="3" <?php if($entry->rights == 3) echo "SELECTED"; ?>>Zugriff nur f&uuml;r Autoren + alle &uuml;bergeordneten Gruppen</option>
				<option value="4" <?php if($entry->rights == 4) echo "SELECTED"; ?>>Zugriff nur f&uuml;r Administratoren</option>
				</select><br />
				<button type="submit" class="btn btn-success">Speichern</button>
				</fieldset>
				</form></div></div></div></div></div>

<?php
}
}

if($rights >= 3 && $_GET['add'] == "do"){
if($_POST['title'] != "" && $_POST['content'] != "" && is_numeric($_POST['rights'])){
mysql_query("INSERT INTO blog (`title`,`content`,`rights`,`date`) VALUES ('".mysql_real_escape_string($_POST['title'])."','".mysql_real_escape_string($_POST['content'])."','".mysql_real_escape_string($_POST['rights'])."',".time().")");
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

if($_GET['action'] == "add" && $rights >= 3){
?><div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1 id="type">Blog-Beitrag hinzuf&uuml;gen</h1>
<form class="form-horizontal" method="POST" action="?p=<?=$_GET['p']; ?>&add=do">
				<fieldset>
				<input type="text" name="title" placeholder="Titel" class="form-control"><br />
				<textarea class="ckeditor" name="content"></textarea><br />
				<select name="rights" class="form-control">
				<option value="0">Zugriff f&uuml;r alle</option>
				<option value="1">Zugriff nur f&uuml;r registrierte Benutzer + alle &uuml;bergeordneten Gruppen</option>
				<option value="2">Zugriff nur f&uuml;r Mitglieder (Freischaltung erforderlich) + alle &uuml;bergeordneten Gruppen</option>
				<option value="3">Zugriff nur f&uuml;r Autoren + alle &uuml;bergeordneten Gruppen</option>
				<option value="4">Zugriff nur f&uuml;r Administratoren</option>
				</select><br />
				<button type="submit" class="btn btn-success">Beitrag erstellen</button>
				</fieldset>
				</form></div></div></div></div>
<?php
} else {

$sql = mysql_query("SELECT * FROM blog WHERE rights <= ".$rights." ORDER BY date DESC");
if(mysql_num_rows($sql) == 0 && $display == 1){
	?>
	<div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1 id="type">Blog</h1>
				Derzeit sind keine Blog-Eintr&auml;ge vorhanden.<?php if($rights >= 3){ ?><br /><br />
			  <a href="?p=blog&action=add" class="btn btn-success">Beitrag hinzuf&uuml;gen</a><?php } ?>
			</div>
          </div>
        </div>
		</div>
	<?php
} else if($display == 1) {
?>
<div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			 <?php if($rights >= 3){ ?> <a href="?p=blog&action=add" class="btn btn-success">Beitrag hinzuf&uuml;gen</a><?php } ?>
			<?php
			$rows = mysql_num_rows($sql);
			$i = 1;
			while($row = mysql_fetch_object($sql)) {
			?>
              <h1 id="type"><?=$row->title; ?> <small><?=date("d.m.Y",$row->date); ?><?php if($rights >= 3){ ?> :: <a href="?p=blog&action=edit&entry=<?=$row->title; ?>">bearbeiten</a> :: <a href="?p=blog&action=delete&entry=<?=$row->title; ?>">l&ouml;schen</a><?php } ?></small></h1>
				<?=$row->content; ?><?php if($rows != $i) echo "<hr />"; ?>
				<?php 
				$i++;
				} ?>
			</div>
          </div>
        </div>
		</div>
		<?php } } } ?>