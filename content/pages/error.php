<?php
if($_GET['action'] == "logout"){
	header('Location: ./');
	exit;
}
?>
<div class="container" style="margin-top:25px">
<div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1 id="type">Fehler</h1>
				Die angeforderte Seite existiert nicht oder Sie haben keine Berechtigung darauf zuzugreifen.
			</div>
          </div>
        </div>
		</div>