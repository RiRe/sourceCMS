<?php
if($rights == 0){
include("error.php");
} else {
?>
<div class="container" style="margin-top:25px">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1>Profil</h1></div>
			<?php
			if($error_profil == true){
			?>
			<div class="alert alert-danger">
                <h4>Fehler</h4>
                <p><?php echo $_POST['password'] != $_POST['password2'] ? "Die angegebenen Passw&ouml;rter stimmen nicht &uuml;berein." : "Der Benutzername <b>".$_POST['user']."</b> ist bereits vergeben."; ?></p>
              </div>
              <?php } else if($_POST['action'] == "profile") { ?>
	
			<div class="alert alert-success">
                <h4>Gespeichert</h4>
                <p>Ihre &Auml;nderungen wurden erfolgreich &uuml;bernommen.</p>
              </div>
			  <?php } ?>
			  <form method="POST" class="bs-example form-horizontal">
				<fieldset>
                  <div class="form-group">
                    <label for="inputUser" class="col-lg-2 control-label">Benutzername</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="user" id="inputUser" value="<?=$_SESSION['user']; ?>" placeholder="Benutzername">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Neues Passwort</label>
                    <div class="col-lg-10">
                      <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Neues Passwort">
               
                    </div>
                  </div>
				   <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Passwort wiederholen</label>
                    <div class="col-lg-10">
                      <input type="password" class="form-control" name="password2" id="inputPassword" placeholder="Passwort wiederholen">
               <input type="hidden" name="action" value="profile">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button type="submit" class="btn btn-primary">&Auml;ndern</button> 
                      <button type="reset" class="btn btn-default">Zur&uuml;cksetzen</button> 
                    </div>
                  </div>
                </fieldset>
			  </form>
			</div>
        </div>
		</div>
		<?php } ?>