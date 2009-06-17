<?php echo $html->docType('xhtml-trans'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>IRCube - <?php echo $title_for_layout; ?></title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<?php echo $html->css(array('_main', 'pagination', 'noscript'));?>
<?php echo $javascript->link(array('jquery/jquery', 'jquery/jquery-ui-packed', 'menu_principal'));?>
<?php echo $scripts_for_layout; ?>

<!-- Meta données -->
<?=$html->charset('utf-8');?>
<meta name="description" content="R&eacute;seau de discussion gratuite IRCube : <?php echo $title_for_layout; ?>" />

<body >
<div id="externe">
	<noscript>
		<div id="noscriptoverlay"></div>
		<div id="noscriptwrapper" class="main_with">
			<h1>JavaScript doit être activé !</h1>
			<p>
				Pour activer JavaScript, consultez ce lien : <br /><a href="http://www.google.com/support/websearch/bin/answer.py?hl=fr&amp;answer=23852" title="Activer JavaScript">http://www.google.com/support/websearch/bin/answer.py?hl=fr&amp;answer=23852</a>
			</p> 
			
		</div>
	</noscript>
	<div id="loginbar">
		<div class="main_width">
			<span style="float: left;">
				Panneau d'administration IRCube
			</span>
			<span class="right">
				<?php
					if($profileHelper->isLoggedIn($AuthUser)):
				?>
						Bienvenue <?php echo $profileHelper->link(null, $AuthUser) ?> - <?php echo $profileHelper->link(__('Mon profil', true), $AuthUser); ?> - <?php echo $html->link(__('Déconnexion', true), array('controller' => 'user_profiles', 'action' => 'logout')); ?>
				<?php
					else:
						echo $html->link(__('Login', true), array('controller' => 'user_profiles', 'action' => 'login'));
				?>
				<?php
					endif;
				?>
			</span>
		</div>
	</div>
	<div id="header">
		<div id="headerbar" class="main_width">
			<?php echo $html->link($html->image('header.jpg', array('alt' => 'IRCube, R&eacute;seau IRC francophone')), '/', array(), false, false); ?>
		</div>
	</div>
	<?php 
		/* Admin menu */
		echo $this->element('menu_principal', array('menuPrincipal' => $menuPrincipal));
	?>
	<div class="clear"></div>			
	<div id="page" class="main_width">


		<?php
		if ($session->check('Message.auth')) 
			$session->flash('auth');
		?>
		
		<?php $session->flash(); ?>
		
		<?php if ($session->check('Message.flash'))
		{
		    $session->flash();
		}
		?>
		<?php
			//La page
			echo $content_for_layout
		?>
		<div class="clear"></div>
		<div id="footer" class="main_width">
				Conception <a href="http://sebastien-charrier.com" title="Chef de projet web">S&eacute;bastien Charrier</a> &amp; Damien Mathieu - Déclaration CNIL n° 1129692
		</div>
	</div>
</div>
</body>
</html>
