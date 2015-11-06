<?php
if($rights > 0 || AUTH == 0 || WARTUNG == 1){
include("error.php");
} else {
?>
<div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
			<h1 id="type">Registrieren</h1>
			<?php
			if($error_reg == true){
			?>
			<div class="alert alert-warning">
                <h4>Fehler</h4>
                <p><?php echo $_POST['password'] != $_POST['password2'] ? "Die angegebenen Passw&ouml;rter stimmen nicht &uuml;berein." : "Der Benutzername ist bereits vergeben."; ?></p>
              </div>
              <?php } ?>
			  <form method="POST" class="bs-example form-horizontal" action="?p=registrieren">
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
               
                    </div>
                  </div>
				   <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Passwort wiederholen</label>
                    <div class="col-lg-10">
                      <input type="password" class="form-control" name="password2" id="inputPassword" placeholder="Passwort wiederholen">
               
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button type="submit" class="btn btn-primary">Registrieren</button> 
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