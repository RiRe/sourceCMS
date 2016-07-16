<?php
if($rights >= RIGHTS_NEEDED){
	include("error.php");
} else {
?>
<div class="container" style="margin-top:25px">
  <div class="row">
    <div class="col-lg-12">
      <div class="page-header">
        <h1>Zugriff verweigert</h1>
	  </div>

      Sie haben nicht die Rechte, um auf diese Seite zugreifen zu k&ouml;nnen.<br /><br />
	  Bitte wenden Sie sich an den Administrator oder registrieren Sie sich.
    </div>
  </div>
</div>
<?php } ?>