<?php
$display = 1;

if(WARTUNG == 1 && $rights < 3){
include("wartung.php");
} else if ($rights < RIGHTS_NEEDED) {
include("forbidden.php");
} else {
if($rights >= 3 && $_GET['a1'] == "delete") $db->query("DELETE FROM blog WHERE title = '".$db->real_escape_string(urldecode($_GET['a2']))."' AND rights <= ".$rights." LIMIT 1");

if($rights >= 3 && $_POST['action'] == "edit"){
if($_POST['title'] != "" && $_POST['content'] != "" && is_numeric($_POST['rights'])){
$db->query("UPDATE blog SET title = '".$db->real_escape_string($_POST['title'])."', content = '".$db->real_escape_string($_POST['content'])."', rights = '".$db->real_escape_string($_POST['rights'])."' WHERE title = '".$db->real_escape_string(urldecode($_GET['a2']))."' LIMIT 1");
header('Location: blog.html');
exit;
} else {
$display = 0;
?>
<div class="container" style="margin-top:25px">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1>Fehler</h1></div>
			<?php
echo "Bitte f&uuml;llen Sie alle Felder aus und gehen Sie nun <a href=\"javascript:history.back()\">zur&uuml;ck</a>.";
?>
          </div>
        </div>
		</div>
<?php
}
}


if($rights >= 3 && $_GET['a1'] == "edit" && $_GET['a2'] != ""){
$sql = $db->query("SELECT * FROM blog WHERE title = '".$db->real_escape_string(urldecode($_GET['a2']))."' AND rights <= ".$rights);
if($sql->num_rows == 1){
$display = 0;
$entry = $sql->fetch_object();
?>
<div class="container" style="margin-top:25px">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1>Beitrag bearbeiten</h1></div>
<form class="form-horizontal" method="POST">
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
				<input type="hidden" name="action" value="edit">
				<button type="submit" class="btn btn-success">Speichern</button>
				</fieldset>
				</form></div></div></div></div>

<?php
}
}

if($rights >= 3 && $_POST['action'] == "add"){
if($_POST['title'] != "" && $_POST['content'] != "" && is_numeric($_POST['rights'])){
$db->query("INSERT INTO blog (`title`,`content`,`rights`,`date`) VALUES ('".$db->real_escape_string($_POST['title'])."','".$db->real_escape_string($_POST['content'])."','".$db->real_escape_string($_POST['rights'])."',".time().")");
header('Location: blog.html');
exit;
} else {
$display = 0;
?>
<div class="container" style="margin-top:25px">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1>Fehler</h1></div>
			<?php
echo "Bitte f&uuml;llen Sie alle Felder aus und gehen Sie nun <a href=\"javascript:history.back()\">zur&uuml;ck</a>.";
?>
          </div>
        </div>
		</div>
<?php
}
}

if($_GET['a1'] == "add" && $rights >= 3){
?><div class="container" style="margin-top:25px">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1>Blog-Beitrag hinzuf&uuml;gen</h1></div>
<form class="form-horizontal" method="POST">
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
				<input type="hidden" name="action" value="add">
				<button type="submit" class="btn btn-success">Beitrag erstellen</button>
				</fieldset>
				</form></div></div></div>
<?php
} else {

$sql = $db->query("SELECT * FROM blog WHERE rights <= ".$rights." ORDER BY date DESC");
if($sql->num_rows == 0 && $display == 1){
	?>
	<div class="container" style="margin-top:25px">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1>Blog</h1></div>
				Derzeit sind keine Blog-Eintr&auml;ge vorhanden.<?php if($rights >= 3){ ?><br /><br />
			  <a href="./blog_add.html" class="btn btn-success">Beitrag hinzuf&uuml;gen</a><?php } ?>
			</div>
        </div>
		</div>
	<?php
} else if($display == 1) {
?>
<div class="container" style="margin-top:25px">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
            <h1>Blog <?php if($rights >= 3){ ?> <a href="./blog_add.html" class="btn btn-success btn-xs">Beitrag hinzuf&uuml;gen</a><?php } ?></h1>
			 </div>
			<?php
			$rows = $sql->num_rows;
			$i = 1;
			while($row = $sql->fetch_object()) {
			?>
              <h1><?=$row->title; ?> <small><?=date("d.m.Y",$row->date); ?><?php if($rights >= 3){ ?> :: <a href="./blog_edit_<?=$row->title; ?>.html">bearbeiten</a> :: <a href="blog_delete_<?=$row->title; ?>.html">l&ouml;schen</a><?php } ?></small></h1>
				<?=$row->content; ?><?php if($rows != $i) echo "<hr />"; ?>
				<?php 
				$i++;
				} ?>
			</div>
        </div>
		</div>
		<?php } } } ?>