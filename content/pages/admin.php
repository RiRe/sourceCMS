<?php
$action = isset($_GET['a1']) ? $_GET['a1'] : "users";

if($rights < 4){
include("error.php");
} else {


if($action == "reset" && isset($_GET['a2']) && !empty($_SESSION['reset']) && $_GET['a2'] == $_SESSION['reset']){
	$db->query("DROP TABLE `blog`, `config`, `pages`, `statistics`, `users`;");
	header('Location: ./');
	exit;
}
?>
<div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1 id="type">Administration</h1></div>
<ul class="nav nav-pills">
                <li<?php if($action == "users") echo ' class="active"'; ?>><a href="admin_users.html">Benutzer <span class="badge"><?php echo $db->query("SELECT * FROM users")->num_rows; ?></span></a></li>
				<li<?php if($action == "stats") echo ' class="active"'; ?>><a href="admin_stats.html">Statistiken</a></li>
                <li<?php if($action == "settings") echo ' class="active"'; ?>><a href="admin_settings.html">Einstellungen</a></li>
                <li<?php if($action == "reset") echo ' class="active"'; ?>><a href="admin_reset.html">Zur&uuml;cksetzen</a></li>
              </ul><br />
			<noscript><div class="alert alert-warning"><h4>JavaScript deaktiviert</h4><p>Bitte aktivieren Sie JavaScript, der Funktionsumfang dieser Webseite ist sonst eventuell eingeschr&auml;nkt.</p></div></noscript>
			  <?php if($action == "users"){ ?>
			  <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Gruppe</th>
                    <th>Aktion</th>
                  </tr>
                </thead>
                <tbody>
				<?php
if($_GET['a2'] == "pw" && urldecode($_GET['a3']) != $_SESSION['user']) $db->query("UPDATE users SET password = '".hash_password($_GET['a4'])."' WHERE user = '".$db->real_escape_string(urldecode($_GET['a3']))."' LIMIT 1");
if($_GET['a2'] != "" && $_POST['right_group'] != "" && urldecode($_GET['a2']) != $_SESSION['user']) $db->query("UPDATE users SET rights = ".$db->real_escape_string($_POST['right_group'])." WHERE user = '".$db->real_escape_string(urldecode($_GET['a2']))."' LIMIT 1");
if($_GET['a2'] == "delete" && urldecode($_GET['a3']) != $_SESSION['user']) $db->query("DELETE FROM users WHERE user = '".$db->real_escape_string(urldecode($_GET['a3']))."' LIMIT 1");
				$sql = $db->query("SELECT * FROM users");
					$i = 0;
					while($row = $sql->fetch_object()){
					$i++;
				?>
				<script type="text/javascript">
					function new_pw_<?=$i; ?>(){
						var e = prompt("Wie soll das neue Passwort von <?=$row->user; ?> lauten?");
						if(e != "" && e != null) window.location = "admin_users_pw_<?=$row->user; ?>_" + e + ".html";
					}
				</script>
                  <tr>
				  <form method="POST" action="admin_users_<?=$row->user; ?>.html">
                    <td style="vertical-align: middle;"><?=$row->user; ?></td>
                    <td><?php if($_SESSION['user'] == $row->user){ ?><?php if($row->rights == 1){ echo "Registriert"; } else if($row->rights == 2) { echo "Mitglied"; } else if($row->rights == 3) { echo "Autor"; } else { echo "Administrator"; } ?><?php } else { ?>
					<select name="right_group" class="form-control input-sm"> 
						<option value="0" <?php if($row->rights == 0) echo "SELECTED"; ?>>Gesperrt</option>
						<option value="1" <?php if($row->rights == 1) echo "SELECTED"; ?>>Registriert</option>
						<option value="2" <?php if($row->rights == 2) echo "SELECTED"; ?>>Mitglied</option>
						<option value="3" <?php if($row->rights == 3) echo "SELECTED"; ?>>Autor</option>
						<option value="4" <?php if($row->rights == 4) echo "SELECTED"; ?>>Administrator</option>
					</select>
					<?php } ?></td>
                    <td style="vertical-align: middle;"><?php if($_SESSION['user'] != $row->user){ ?><button type="submit" class="btn btn-xs btn-success">Speichern</button>&nbsp;<a href="javascript:new_pw_<?=$i; ?>();" class="btn btn-xs btn-warning">Neues Passwort</a>&nbsp;<a href="admin_users_delete_<?=$row->user; ?>.html" class="btn btn-danger btn-xs">L&ouml;schen</a><?php } else { echo "Dies ist Ihr Konto."; } ?></td>
				</form>
				  </tr>
				  <?php
					}
				?>
				  </tbody>
				  </table>
			  <?php } else if($action == "stats"){ ?>
			  	<div id="curve_chart" style="width: 100%; height: auto;"></div>

			  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			    <script type="text/javascript">
			      google.charts.load('current', {'packages':['corechart']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['Tag', 'Besucher', 'Seitenaufrufe'],
			          ['<?=date("d.m.Y", strtotime("-6 days")); ?>', <?=$db->query("SELECT visitors FROM statistics WHERE day = '".date("d.m.Y", strtotime("-6 days"))."' LIMIT 1")->fetch_object()->visitors ?: "0"; ?>, <?=$db->query("SELECT sites FROM statistics WHERE day = '".date("d.m.Y", strtotime("-6 days"))."' LIMIT 1")->fetch_object()->sites ?: "0"; ?>],
			          ['<?=date("d.m.Y", strtotime("-5 days")); ?>', <?=$db->query("SELECT visitors FROM statistics WHERE day = '".date("d.m.Y", strtotime("-5 days"))."' LIMIT 1")->fetch_object()->visitors ?: "0"; ?>, <?=$db->query("SELECT sites FROM statistics WHERE day = '".date("d.m.Y", strtotime("-5 days"))."' LIMIT 1")->fetch_object()->sites ?: "0"; ?>],
			          ['<?=date("d.m.Y", strtotime("-4 days")); ?>', <?=$db->query("SELECT visitors FROM statistics WHERE day = '".date("d.m.Y", strtotime("-4 days"))."' LIMIT 1")->fetch_object()->visitors ?: "0"; ?>, <?=$db->query("SELECT sites FROM statistics WHERE day = '".date("d.m.Y", strtotime("-4 days"))."' LIMIT 1")->fetch_object()->sites ?: "0"; ?>],
			          ['<?=date("d.m.Y", strtotime("-3 days")); ?>', <?=$db->query("SELECT visitors FROM statistics WHERE day = '".date("d.m.Y", strtotime("-3 days"))."' LIMIT 1")->fetch_object()->visitors ?: "0"; ?>, <?=$db->query("SELECT sites FROM statistics WHERE day = '".date("d.m.Y", strtotime("-3 days"))."' LIMIT 1")->fetch_object()->sites ?: "0"; ?>],
			          ['<?=date("d.m.Y", strtotime("-2 days")); ?>', <?=$db->query("SELECT visitors FROM statistics WHERE day = '".date("d.m.Y", strtotime("-2 days"))."' LIMIT 1")->fetch_object()->visitors ?: "0"; ?>, <?=$db->query("SELECT sites FROM statistics WHERE day = '".date("d.m.Y", strtotime("-2 days"))."' LIMIT 1")->fetch_object()->sites ?: "0"; ?>],
			          ['<?=date("d.m.Y", strtotime("-1 days")); ?>', <?=$db->query("SELECT visitors FROM statistics WHERE day = '".date("d.m.Y", strtotime("-1 days"))."' LIMIT 1")->fetch_object()->visitors ?: "0"; ?>, <?=$db->query("SELECT sites FROM statistics WHERE day = '".date("d.m.Y", strtotime("-1 days"))."' LIMIT 1")->fetch_object()->sites ?: "0"; ?>],
			          ['<?=date("d.m.Y"); ?>', <?=$db->query("SELECT visitors FROM statistics WHERE day = '".date("d.m.Y")."' LIMIT 1")->fetch_object()->visitors ?: "0"; ?>, <?=$db->query("SELECT sites FROM statistics WHERE day = '".date("d.m.Y")."' LIMIT 1")->fetch_object()->sites; ?>],
			        ]);

			        var options = {
			          curveType: 'function',
			          legend: { position: 'top' },
			          min: 0,
			          vAxis: {minValue: 0},
			        };

			        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

			        chart.draw(data, options);
			      }
			    </script>
			  <?php } else if($action == "reset") { ?>
			  	<p style="text-align: justify;">Hier k&ouml;nnen Sie sourceCMS auf Werkseinstellungen zur&uuml;cksetzen. <b>Dadurch werden alle Daten gel&ouml;scht!</b></p>

			  	<?php $_SESSION['reset'] = rand(100000,999999); ?>
			  	<a href="admin_reset_<?=$_SESSION['reset']; ?>.html" onclick="return confirm('Sollen wirklich alle Daten geloescht werden?');" class="btn btn-danger btn-block">Alle Daten l&ouml;schen</a>
			  <?php } else { 
			  if($_POST['settings'] == "save"){
				$db->query("UPDATE config SET value = '".$db->real_escape_string($_POST['template'])."' WHERE `key` = 'template' LIMIT 1");
				$db->query("UPDATE config SET value = '".$db->real_escape_string($_POST['sitename'])."' WHERE `key` = 'sitename' LIMIT 1");
				$db->query("UPDATE config SET value = '".$db->real_escape_string($_POST['wartung'])."' WHERE `key` = 'wartung' LIMIT 1");
				$db->query("UPDATE config SET value = '".$db->real_escape_string($_POST['blog'])."' WHERE `key` = 'blog' LIMIT 1");
				$db->query("UPDATE config SET value = '".$db->real_escape_string($_POST['auth'])."' WHERE `key` = 'auth' LIMIT 1");
				$db->query("UPDATE config SET value = '".$db->real_escape_string($_POST['right_group'])."' WHERE `key` = 'rights_needed' LIMIT 1");
				
				header('Location: admin_settings.html');
				exit;
			  }
			  ?>
			  			  <form method="POST" class="form-horizontal">
				<input type="hidden" name="settings" value="save">
				<fieldset>
                  <div class="form-group">
                    <label for="inputUser" class="col-lg-2 control-label">Seitenname</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="sitename" id="inputUser" value="<?=SITENAME; ?>" placeholder="Seitenname">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Design</label>
                    <div class="col-lg-10">
                      <select class="form-control" name="template">
						<option value="default"<?php if(TEMPLATE == "default") echo " selected"; ?>>Standard (Hell)</option>
						<option value="yeti"<?php if(TEMPLATE == "yeti") echo " selected"; ?>>Standard (Dunkel)</option>
						<option value="amelia"<?php if(TEMPLATE == "amelia") echo " selected"; ?>>Rot-Gr&uuml;n</option>
						<option value="cerulean"<?php if(TEMPLATE == "cerulean") echo " selected"; ?>>Hellblau</option>
						<option value="cosmo"<?php if(TEMPLATE == "cosmo") echo " selected"; ?>>Dunkel</option>
						<option value="cyborg"<?php if(TEMPLATE == "cyborg") echo " selected"; ?>>Wei&szlig; auf schwarz</option>
						<option value="flatly"<?php if(TEMPLATE == "flatly") echo " selected"; ?>>Dunkelgr&uuml;n</option>
						<option value="journal"<?php if(TEMPLATE == "journal") echo " selected"; ?>>Zeitung</option>
						<option value="readable"<?php if(TEMPLATE == "readable") echo " selected"; ?>>Barrierefrei</option>
						<option value="simplex"<?php if(TEMPLATE == "simplex") echo " selected"; ?>>Minimal</option>
						<option value="slate"<?php if(TEMPLATE == "slate") echo " selected"; ?>>Metall</option>
						<option value="spacelab"<?php if(TEMPLATE == "spacelab") echo " selected"; ?>>Silber</option>
						<option value="united"<?php if(TEMPLATE == "united") echo " selected"; ?>>Helles Rot</option>
					  </select>
                    </div>
                  </div>
				   <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Ben&ouml;tigte Rechte</label>
                    <div class="col-lg-10">
                     <select name="right_group" class="form-control"> 
						<option value="0" <?php if(RIGHTS_NEEDED == 0) echo "SELECTED"; ?>>Gast</option>
						<option value="1" <?php if(RIGHTS_NEEDED == 1) echo "SELECTED"; ?>>Registriert</option>
						<option value="2" <?php if(RIGHTS_NEEDED == 2) echo "SELECTED"; ?>>Mitglied</option>
						<option value="3" <?php if(RIGHTS_NEEDED == 3) echo "SELECTED"; ?>>Autor</option>
						<option value="4" <?php if(RIGHTS_NEEDED == 4) echo "SELECTED"; ?>>Administrator</option>
					</select>
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="blog" class="col-lg-2 control-label">Blog</label>
                    <div class="col-lg-10">
						<div class="checkbox"><label>
							<input type="checkbox" name="blog" id="blog" value="1" <?php if(BLOG == 1) echo "checked"; ?>>
							Aktivieren Sie einen Blog, mit dem Sie aktuelle Informationen anzeigen lassen k&ouml;nnen
						</label></div>
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="auth" class="col-lg-2 control-label">Registrierung</label>
                    <div class="col-lg-10">
						<div class="checkbox"><label>
							<input type="checkbox" name="auth" id="auth" value="1" <?php if(AUTH == 1) echo "checked"; ?>>
							M&ouml;chten Sie die Registrierung neuer Benutzer zulassen? Diese werden registrierte Benutzer.
						</label></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="wartung" class="col-lg-2 control-label">Wartungsmodus</label>
                    <div class="col-lg-10">
						<div class="checkbox"><label>
							<input type="checkbox" name="wartung" value="1" id="wartung" <?php if(WARTUNG == 1) echo "checked"; ?>>
							Im Wartungsmodus ist die Seite nur f&uuml;r Autoren und Administratoren erreichbar.
						</label></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button type="submit" class="btn btn-primary">Speichern</button> 
                      <button type="reset" class="btn btn-default">Zur&uuml;cksetzen</button> 
                    </div>
                  </div>
                </fieldset>
			  </form>
			  <?php } ?>
			</div>
          </div>
        </div>
		<?php } ?>