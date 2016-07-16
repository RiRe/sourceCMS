<?php
if($rights < 3){
include("error.php");
} else if($_POST['action'] == "create"){
if($_POST['title'] != "" && $_POST['content'] != "" && $_POST['slug'] != "" && is_numeric($_POST['rights'])){
$db->query("INSERT INTO pages (`title`,`slug`,`content`,`rights`) VALUES ('".$db->real_escape_string($_POST['title'])."','".strtolower($db->real_escape_string($_POST['slug']))."','".$db->real_escape_string($_POST['content'])."','".$db->real_escape_string($_POST['rights'])."')");
header('Location: ./'.$_POST['slug'] . '.html');
exit;
} else {
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
} else {
?>
<div class="container" style="margin-top:25px">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1>Seite erstellen</h1>
			</div>
<form class="form-horizontal" method="POST">
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
				<input type="hidden" name="action" value="create">
				<button type="submit" class="btn btn-success">Seite erstellen</button>
				</fieldset>
				</form>
			</div>
          </div>
        </div>
		<?php } ?>