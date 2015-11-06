<?php
if($rights < 4){
include("error.php");
} else {
$action = $_GET['action'];
if($action == "") $action = "users";
?>
<div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1 id="type">Administration</h1>
<ul class="nav nav-pills">
                <li<?php if($action == "users") echo ' class="active"'; ?>><a href="?p=admin&action=users">Benutzer <span class="badge"><?php echo mysql_num_rows(mysql_query("SELECT * FROM users")); ?></span></a></li>
				<li<?php if($action == "stats") echo ' class="active"'; ?>><a href="?p=admin&action=stats">Statistiken</a></li>
                <li<?php if($action == "settings") echo ' class="active"'; ?>><a href="?p=admin&action=settings">Einstellungen <span class="badge"></span></a></li>
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
if($_GET['new_pw'] != "" && $_GET['pw'] != "" && urldecode($_GET['new_pw']) != $_SESSION['user']) mysql_query("UPDATE users SET password = '".hash_password($_GET['pw'])."' WHERE user = '".mysql_real_escape_string(urldecode($_GET['new_pw']))."' LIMIT 1");
if($_GET['user'] != "" && $_POST['right_group'] != "" && urldecode($_GET['user']) != $_SESSION['user']) mysql_query("UPDATE users SET rights = ".$_POST['right_group']." WHERE user = '".mysql_real_escape_string(urldecode($_GET['user']))."' LIMIT 1");
if($_GET['delete'] != "" && urldecode($_GET['delete']) != $_SESSION['user']) mysql_query("DELETE FROM users WHERE user = '".mysql_real_escape_string(urldecode($_GET['delete']))."' LIMIT 1");
echo mysql_error();				
				$sql = mysql_query("SELECT * FROM users");
					$i = 0;
					while($row = mysql_fetch_object($sql)){
					$i++;
				?>
				<script type="text/javascript">
					function new_pw_<?=$i; ?>(){
						var e = prompt("Wie soll das neue Passwort von <?=$row->user; ?> lauten?");
						if(e != "" && e != null) window.location = "?p=admin&action=users&new_pw=<?=$row->user; ?>&pw=" + e;
					}
				</script>
                  <tr>
				  <form method="POST" action="?p=admin&action=users&user=<?=$row->user; ?>">
                    <td><?=$row->user; ?></td>
                    <td><?php if($_SESSION['user'] == $row->user){ ?><?php if($row->rights == 1){ echo "Registriert"; } else if($row->rights == 2) { echo "Mitglied"; } else if($row->rights == 3) { echo "Autor"; } else { echo "Administrator"; } ?><?php } else { ?>
					<select name="right_group" class="form-control"> 
						<option value="0" <?php if($row->rights == 0) echo "SELECTED"; ?>>Gesperrt</option>
						<option value="1" <?php if($row->rights == 1) echo "SELECTED"; ?>>Registriert</option>
						<option value="2" <?php if($row->rights == 2) echo "SELECTED"; ?>>Mitglied</option>
						<option value="3" <?php if($row->rights == 3) echo "SELECTED"; ?>>Autor</option>
						<option value="4" <?php if($row->rights == 4) echo "SELECTED"; ?>>Administrator</option>
					</select>
					<?php } ?></td>
                    <td><?php if($_SESSION['user'] != $row->user){ ?><button type="submit" class="btn btn-success">Speichern</button>&nbsp;<a href="javascript:new_pw_<?=$i; ?>();" class="btn btn-warning">Neues Passwort</a>&nbsp;<a href="?p=admin&action=users&delete=<?=$row->user; ?>" class="btn btn-danger">L&ouml;schen</a><?php } else { echo "Dies ist Ihr Konto."; } ?></td>
				</form>
				  </tr>
				  <?php
					}
				?>
				  </tbody>
				  </table>
			  <?php } else if($action == "stats"){ ?>
			  <canvas id="myChart" width="800" height="400"></canvas><script>document.write("<br />Hellblau - Besucher<br />Grau - Seitenaufrufe");</script>
			  <script src="js/Chart.js"></script>
			  <script type="text/javascript">
			  var ctx = document.getElementById("myChart").getContext("2d");
				
				var data = {
	labels : ["<?=date("d.m.Y",(time() - 60*60*24*6)); ?>","<?=date("d.m.Y",(time() - 60*60*24*5)); ?>","<?=date("d.m.Y",(time() - 60*60*24*4)); ?>","<?=date("d.m.Y",(time() - 60*60*24*3)); ?>","<?=date("d.m.Y",(time() - 60*60*24*2)); ?>","Gestern","Heute"],
	datasets : [
		{
			fillColor : "rgba(220,220,220,0.5)",
			strokeColor : "rgba(220,220,220,1)",
			pointColor : "rgba(220,220,220,1)",
			pointStrokeColor : "#fff",
			<?php
			$sql = mysql_fetch_object(mysql_query("SELECT * FROM statistics WHERE day = '".date("d.m.Y")."' LIMIT 1"));
			$today_visitors = $sql->visitors;
			$today_sites = $sql->sites;
			
			$sql = mysql_fetch_object(mysql_query("SELECT * FROM statistics WHERE day = '".date("d.m.Y",(time() - 60*60*24*1))."' LIMIT 1"));
			$yd_visitors = $sql->visitors;
			$yd_sites = $sql->sites;
			
			$sql = mysql_fetch_object(mysql_query("SELECT * FROM statistics WHERE day = '".date("d.m.Y",(time() - 60*60*24*2))."' LIMIT 1"));
			$d3_visitors = $sql->visitors;
			$d3_sites = $sql->sites;
			
			$sql = mysql_fetch_object(mysql_query("SELECT * FROM statistics WHERE day = '".date("d.m.Y",(time() - 60*60*24*3))."' LIMIT 1"));
			$d4_visitors = $sql->visitors;
			$d4_sites = $sql->sites;
			
			$sql = mysql_fetch_object(mysql_query("SELECT * FROM statistics WHERE day = '".date("d.m.Y",(time() - 60*60*24*4))."' LIMIT 1"));
			$d5_visitors = $sql->visitors;
			$d5_sites = $sql->sites;
			
			$sql = mysql_fetch_object(mysql_query("SELECT * FROM statistics WHERE day = '".date("d.m.Y",(time() - 60*60*24*5))."' LIMIT 1"));
			$d6_visitors = $sql->visitors;
			$d6_sites = $sql->sites;
			
			$sql = mysql_fetch_object(mysql_query("SELECT * FROM statistics WHERE day = '".date("d.m.Y",(time() - 60*60*24*6))."' LIMIT 1"));
			$d7_visitors = $sql->visitors;
			$d7_sites = $sql->sites;
			?>
			data : [<?=$d7_sites; ?>,<?=$d6_sites; ?>,<?=$d5_sites; ?>,<?=$d4_sites; ?>,<?=$d3_sites; ?>,<?=$yd_sites; ?>,<?=$today_sites; ?>]
		},
		{
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,1)",
			pointColor : "rgba(151,187,205,1)",
			pointStrokeColor : "#fff",
			data : [<?=$d7_visitors; ?>,<?=$d6_visitors; ?>,<?=$d5_visitors; ?>,<?=$d4_visitors; ?>,<?=$d3_visitors; ?>,<?=$yd_visitors; ?>,<?=$today_visitors; ?>]
		}
	]
}

new Chart(ctx).Line(data);
			  </script>
			  <?php } else { 
			  if($_POST['settings'] == "save"){
				mysql_query("UPDATE config SET value = '".mysql_real_escape_string($_POST['template'])."' WHERE `key` = 'template' LIMIT 1");
				echo mysql_error();
				mysql_query("UPDATE config SET value = '".mysql_real_escape_string($_POST['sitename'])."' WHERE `key` = 'sitename' LIMIT 1");
				echo mysql_error();
				mysql_query("UPDATE config SET value = '".mysql_real_escape_string($_POST['wartung'])."' WHERE `key` = 'wartung' LIMIT 1");
				echo mysql_error();
				mysql_query("UPDATE config SET value = '".mysql_real_escape_string($_POST['blog'])."' WHERE `key` = 'blog' LIMIT 1");
				echo mysql_error();
				mysql_query("UPDATE config SET value = '".mysql_real_escape_string($_POST['auth'])."' WHERE `key` = 'auth' LIMIT 1");
				echo mysql_error();
				mysql_query("UPDATE config SET value = '".mysql_real_escape_string($_POST['right_group'])."' WHERE `key` = 'rights_needed' LIMIT 1");
				echo mysql_error();
				mysql_query("UPDATE config SET value = '".mysql_real_escape_string($_POST['javascript'])."' WHERE `key` = 'javascript' LIMIT 1");
				echo mysql_error();
				mysql_query("UPDATE config SET value = '".mysql_real_escape_string($_POST['debug'])."' WHERE `key` = 'debug' LIMIT 1");
				echo mysql_error();
				
				header('Location: ?p=admin&action=settings');
				exit;
			  }
			  ?>
			  			  <form method="POST" class="bs-example form-horizontal" action="?p=admin&action=settings">
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
                    <label for="inputPassword" class="col-lg-2 control-label">JavaScript</label>
                    <div class="col-lg-10">
                
					<label style="font-weight:normal"><input type="checkbox" name="javascript" value="1" <?php if(JAVASCRIPT == 1) echo "checked"; ?>> Aktivieren Sie JavaScript f&uuml;r ein besseres Erlebnis. Benutzer ohne JavaScript sehen die Standard-Version.</label>
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Blog</label>
                    <div class="col-lg-10">
                
					<label style="font-weight:normal"><input type="checkbox" name="blog" value="1" <?php if(BLOG == 1) echo "checked"; ?>> Aktivieren Sie einen Blog, mit dem Sie aktuelle Informationen anzeigen lassen k&ouml;nnen</label>
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Registrierung</label>
                    <div class="col-lg-10">
                
					<label style="font-weight:normal"><input type="checkbox" name="auth" value="1"  <?php if(AUTH == 1) echo "checked"; ?>> M&ouml;chten Sie die Registrierung neuer Benutzer zulassen? Diese werden registrierte Benutzer.</label>
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Debug</label>
                    <div class="col-lg-10">
                
					<label style="font-weight:normal"><input type="checkbox" name="debug" value="1"  <?php if(DEBUG == 1) echo "checked"; ?>> Der Debug-Modus zeigt Informationen zum Ablauf des Scriptes an und l&auml;sst sich zur Fehlersuche verwenden.</label>
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Wartungsmodus</label>
                    <div class="col-lg-10">
                
					<label style="font-weight:normal"><input type="checkbox" name="wartung" value="1"  <?php if(WARTUNG == 1) echo "checked"; ?>> Im Wartungsmodus ist die Seite nur f&uuml;r Autoren und Administratoren erreichbar.</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button type="submit" class="btn btn-primary">Absenden</button> 
                      <button type="reset" class="btn btn-default">Reset</button> 
                    </div>
                  </div>
                </fieldset>
			  </form>
			  <?php } ?>
			</div>
          </div>
        </div>
		</div>
		<?php } ?>