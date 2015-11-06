<?php
if($rights > 0){
include("error.php");
} else {
?>
<div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1 id="type">Login</h1>
			<?php
			if($error_login == 1){
			?>
			<div class="alert alert-danger">
                <h4>Login fehlgeschlagen</h4>
                <p>Bitte &uuml;berpr&uuml;fen Sie Ihren Benutzernamen und Ihr Passwort.</p>
              </div>
			  <?php } else if($error_login == 2) { ?>
			<div class="alert alert-danger">
                <h4>Konto gesperrt</h4>
                <p>Ihr Konto wurde gesperrt. Bitte setzen Sie sich mit uns in Verbindung.</p>
              </div>
			  <?php } ?>
              <form method="POST" class="bs-example form-horizontal" action="?p=login">
				<fieldset>
                  <div class="form-group">
                    <label for="inputUser" class="col-lg-2 control-label">Benutzername</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="user" id="inputUser" value="<?=$_POST['user']; ?>" placeholder="Benutzername">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Passwort</label>
                    <div class="col-lg-10">
                      <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Passwort">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="stayloggedin" value="yes" <?php if($_POST['stayloggedin'] == "true") echo "checked"; ?>> Ich m&ouml;chte eine Woche lang eingeloggt bleiben
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button type="submit" class="btn btn-primary">Einloggen</button> 
                      <button type="reset" class="btn btn-default">Reset</button> 
                    </div>
                  </div>
                </fieldset>
			  </form>
			</div>
          </div>
        </div>
		</div>
		<?php } ?>