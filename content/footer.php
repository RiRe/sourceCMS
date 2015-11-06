  <div class="container">
  <footer>
        <div class="row">
          <div class="col-lg-12">
            
			&copy; <a href="http://www.virtuasoft.de" target="_blank">virtuaSOFT</a> 2013 - Alle Rechte vorbehalten.
			<?php if($rights == 4 && DEBUG == 1){ 
			$endzeit=explode(" ", microtime());
			$endzeit=$endzeit[0]+$endzeit[1];
			?>
			<br />
			Seite wurde in <?=round($endzeit - $startzeit,6); ?> Sekunden geladen.<br />
			<?php } ?>
            
          </div>
        </div>
        
      </footer>
	  </div>
	  <script src="js/jquery.min.js"></script>
<script src="editor/ckeditor.js"></script>
<script src="editor/adapters/jquery.js"></script>
	  
</body>
</html>