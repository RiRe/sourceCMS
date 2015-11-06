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
            <li<?php if($_GET['p'] == "" || $_GET['p'] == "startseite") echo ' class="active"'; ?>>
              <a href="./"><?php echo WARTUNG == 1 && $rights < 3 ? "Wartungsmodus" : "Startseite"; ?></a>
            </li>
			
<?php
if(WARTUNG != 1 || $rights >= 3){
$sql = mysql_query("SELECT * FROM pages WHERE slug != 'startseite' AND rights <= ".$rights." ORDER BY `index` ASC");
while($row = mysql_fetch_object($sql)){
?>
            <li<?php if($_GET['p'] == $row->slug) echo ' class="active"'; ?>>
              <a href="./?p=<?=$row->slug; ?>"><?=$row->title; ?></a>
            </li>
<?php
}
?>
			<?php if(BLOG == 1){ ?>
            <li<?php if($_GET['p'] == "blog") echo ' class="active"'; ?>>
              <a href="./?p=blog">Blog</a>
            </li>
			<?php } ?>
			<?php if($rights >= 3){ ?>
            <li<?php if($_GET['p'] == "neue_seite") echo ' class="active"'; ?>>
              <a href="./?p=neue_seite">+</a>
            </li>
			<?php } } ?>
          </ul>
<?php if($rights > 0){ ?>
   <ul class="nav navbar-nav navbar-right">
   <?php if($rights >= 4){  ?>
			<li<?php if($_GET['p'] == "admin") echo ' class="active"'; ?>>
				<a href="?p=admin">Administration</a>
            </li>
   <?php } ?>
			<li<?php if($_GET['p'] == "profil") echo ' class="active"'; ?>>
				<a href="?p=profil"><?=$_SESSION['user']; ?></a>
            </li>
			<li>
				<a href="?p=<?=$_GET['p']; ?>&action=logout">Ausloggen</a>
            </li>
		</ul>
<?php } else { ?>
          <ul class="nav navbar-nav navbar-right">
            <li<?php if($_GET['p'] == "login") echo ' class="active"'; ?>><a href="./?p=login">Login</a></li>
			<?php if(AUTH == 1 && WARTUNG != 1){ ?>
            <li<?php if($_GET['p'] == "registrieren") echo ' class="active"'; ?>><a href="./?p=registrieren">Registrieren</a></li>
			<?php } ?>
          </ul>
		  <?php } ?>

        </div>
      </div>
    </div>