<?php echo $html->docType('xhtml-trans'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>IRCube - <?php echo $title_for_layout; ?></title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<?php echo $html->css(array('blueprint/screen.css', 'blueprint/ircube.css')); ?>
<!--[if lt IE 8]><?php echo $html->css(array('blueprint/ie.css')); ?><![endif]-->
<?php echo $html->css(array('uni-form/uni-form.css')); ?>
<?php echo $html->css(array('pagination', 'noscript'));?>
<?php echo $javascript->link(array('jquery/jquery', 'jquery/jquery.uni-form', 'jquery/jquery.corners.min', 'menu_principal'));?>
<?php echo $scripts_for_layout; ?>

<script type="text/javascript">
$(function() {
	$('#loginbar span').corners("6px");
	$('div.ircube-box > h1, div.ircube-box > h2, div.ircube-box > h3').corners("10px top");
	$('div.ircube-box > div.noheader').corners("10px");
	$('div.ircube-box > div.box').corners("10px bottom");
});
</script>

<!-- Meta données -->
<?php echo $html->charset('utf-8');?>
<meta name="description" content="R&eacute;seau de discussion gratuite IRCube : <?php echo $title_for_layout; ?>" />

<body >
<noscript>
	<div id="noscriptoverlay"></div>
	<div id="noscriptwrapper" class="container">
		<h1>JavaScript doit être activé !</h1>
		<p>
			Pour activer JavaScript, consultez ce lien : <br /><a href="http://www.google.com/support/websearch/bin/answer.py?hl=fr&amp;answer=23852" title="Activer JavaScript">http://www.google.com/support/websearch/bin/answer.py?hl=fr&amp;answer=23852</a>
		</p> 
	
	</div>
</noscript>
<div id="header-background">
	<div class="container">
		<div id="header" class="span-24 last">
			<div id="header-logo" class="span-16">
				<?php echo $html->link($html->image('ircube-logo.png', array('alt' => 'IRCube, R&eacute;seau IRC francophone')), '/', array(), false, false); ?>
			</div>
			<div id="loginbar" class="span-8 last">
				<div id="search">
					 <!-- <form action="/search/">
						<input type="text" name="q" value="" />&nbsp;
						<input type="submit" value="<?php __('Ok'); ?>" />&nbsp;<a href="/search/">&raquo; + d'options</a>
					</form>
					/-->
				</div>
				<span class="right">
					<?php
						if(isset($AuthUser) && $profileHelper->isLoggedIn($AuthUser)):
							echo $html->link($AuthUser['username'], array('controller' => 'home', 'action' => 'index')); ?> - <?php echo $html->link(__('Déconnexion', true), array('controller' => 'user_profiles', 'action' => 'logout')); ?>
					<?php
						else:
							echo $html->link(__('Login', true), array('controller' => 'user_profiles', 'action' => 'login'));?> / <?php echo $html->link(__('J\'ai déja un compte Z', true), array('controller' => 'user_profiles', 'action' => 'create_profile'));
					?>


					<?php
						endif;
					?>
				</span>
			</div>
		</div>
		<?php echo $this->element('menu_principal', array('menuPrincipal' => $menuPrincipal)); ?>
	</div>
</div>
<div id="submenubar-background">
	<div class="container">
	<div class="span-24 last">
		<?php echo $this->element('submenu', array('menuPrincipal' => $menuPrincipal)); ?>
	</div>
	</div>
</div>
<div id="background">
	<div class="container">
		<div id="page" class="span-24 last">
			
			<div class="clear"></div>
			<?php
				if ($session->check('Message.auth')) 
					$session->flash('auth');
 				if ($session->check('Message.flash')) {
			    	$session->flash();
				}
			?>
			<div class="clear"></div>
			<?php
				//La page
				echo $content_for_layout
			?>
			<div class="clear"></div>
			<div id="footer" class="span-24 last">
					Conception <a href="http://sebastien-charrier.com" title="Chef de projet web">S&eacute;bastien Charrier</a> &amp; Benjamin Beret - Déclaration CNIL n° 1129692
			</div>
		</div>
	</div>
</div>
</body>
</html>
