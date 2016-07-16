<div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="./" class="navbar-brand"><?=SITENAME; ?></a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <?php if(WARTUNG == 1 && $rights < 3){ ?>
            <li<?php if($_GET['p'] == "wartung") echo ' class="active"'; ?>>
              <a href="./">Wartungsmodus</a>
            </li>
            <?php } ?>
			
<?php
if(WARTUNG != 1 || $rights >= 3){
$sql = $db->query("SELECT * FROM pages WHERE rights <= ".$rights." ORDER BY `slug` = 'startseite' DESC, `index` ASC");
while($row = $sql->fetch_object()){
?>
            <li<?php if($_GET['p'] == $row->slug || (empty($_GET['p']) && $row->slug == "startseite")) echo ' class="active"'; ?>>
              <a href="./<?=$row->slug; ?>.html"><?=$row->title; ?></a>
            </li>
<?php
}
?>
			<?php if(BLOG == 1){ ?>
            <li<?php if($_GET['p'] == "blog") echo ' class="active"'; ?>>
              <a href="./blog.html">Blog</a>
            </li>
			<?php } ?>
			<?php if($rights >= 3){ ?>
            <li<?php if($_GET['p'] == "neu") echo ' class="active"'; ?>>
              <a href="./neu.html">+</a>
            </li>
			<?php } } ?>
          </ul>
<?php if($rights > 0){ ?>
   <ul class="nav navbar-nav navbar-right">
   <?php if($rights >= 4){  ?>
			<li<?php if($_GET['p'] == "admin") echo ' class="active"'; ?>>
				<a href="./admin.html">Administration</a>
            </li>
   <?php } ?>
			<li<?php if($_GET['p'] == "profil") echo ' class="active"'; ?>>
				<a href="./profil.html"><?=$_SESSION['user']; ?></a>
            </li>
			<li>
				<a href="./logout.html">Ausloggen</a>
            </li>
		</ul>
<?php } else { ?>
          <ul class="nav navbar-nav navbar-right">
            <li<?php if($_GET['p'] == "login") echo ' class="active"'; ?>><a href="./login.html">Login</a></li>
			<?php if(AUTH == 1 && WARTUNG != 1){ ?>
            <li<?php if($_GET['p'] == "registrieren") echo ' class="active"'; ?>><a href="./registrieren.html">Registrieren</a></li>
			<?php } ?>
          </ul>
		  <?php } ?>

        </div>
      </div>
    </div>