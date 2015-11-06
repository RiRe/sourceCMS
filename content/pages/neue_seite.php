<?php
if($rights < 3){
include("error.php");
} else if($_GET['action'] == "create"){
if($_POST['title'] != "" && $_POST['content'] != "" && $_POST['slug'] != "" && is_numeric($_POST['rights'])){
mysql_query("INSERT INTO pages (`title`,`slug`,`content`,`rights`) VALUES ('".mysql_real_escape_string($_POST['title'])."','".strtolower(mysql_real_escape_string($_POST['slug']))."','".mysql_real_escape_string($_POST['content'])."','".mysql_real_escape_string($_POST['rights'])."')");
header('Location: ?p='.$_POST['slug']);
exit;
} else {
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
} else {
?>
<div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1 id="type">Seite erstellen</h1>
<form class="form-horizontal" method="POST" action="?p=<?=$_GET['p']; ?>&action=create">
				<fieldset>
				<input type="text" name="title" placeholder="Titel" class="form-control"><br />
				<input type="text" name="slug" placeholder="Einfacher Name (nur Kleinbuchstaben und Unterstriche)" class="form-control"><br />
				<textarea class="ckeditor" name="content"></textarea><br />
				<select name="rights" class="form-control">
				<option value="0">Zugriff f&uuml;r alle</option>
				<option value="1">Zugriff nur f&uuml;r registrierte Benutzer + alle &uuml;bergeordneten Gruppen</option>
				<option value="2">Zugriff nur f&uuml;r Mitglieder (Freischaltung erforderlich) + alle &uuml;bergeordneten Gruppen</option>
				<option value="3">Zugriff nur f&uuml;r Autoren + alle &uuml;bergeordneten Gruppen</option>
				<option value="4">Zugriff nur f&uuml;r Administratorenn</option>
				</select><br />
				<button type="submit" class="btn btn-success">Seite erstellen</button>
				</fieldset>
				</form>
			</div>
          </div>
        </div>
		</div>
		<?php } ?>