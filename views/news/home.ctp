<div id="module_content" class="two_columns">
	<div id="left_zone">
		<div id="news_bloc">
			<h2><?php __('News');?></h2>
			<?php
			foreach ($news as $news) {
				echo $this->element('news', array('news' => $news));
			}
			?>
			<div style="text-align: right;margin-bottom: 5px;">
				<a href="http://ircube.org/news/">Archives des actualit&eacute;s</a> - <a href="http://feeds.feedburner.com/Ircube"><img src="http://ircube.org/images/feed-icon-14x14.png" alt="Flux RSS des actualit&eacute;s" /></a>
			</div>
		</div>
	</div>
	
	<div id="right_zone">
		<div id="welcome_bloc">
			<h2>Bienvenue sur la communauté de <br /> chat IRCube !</h2>
			<ul>
				<li><strong>Chat gratuit</strong> et libre</li>
				<li>Services de chat pour webmasters</li>
				<li>Trombinoscope des utilisateurs</li>
				<li>Base de vos citations</li>
				<li style="font-weight: bold">Un pseudo unique pour vous connecter au site et au chat ! <img src="/themes/commun/images/new.gif" /></li>
			</ul>
			<p id="inscription_button">
				<a href="/users/register/"><img src="/themes/normal/images/bouton_inscrivez_vous.gif" alt="Inscrivez-vous !" /></a>
			</p>
		</div>
		
		<div id="livestats_bloc">
			<h2>Live stats</h2>
			<p>244 utilisateurs connectés, 142 salons actifs</p>
			<p>Etat des serveurs :</p>
			<ul>
									<li>
						<a href="irc://octavien.fr.ircube.org">octavien.fr.ircube.org</a> : 
						<span class="online">online</span> (152)					</li>
									<li>
						<a href="irc://shrubbery.fr.ircube.org">shrubbery.fr.ircube.org</a> : 
						<span class="online">online</span> (73)					</li>
							</ul>
		</div>

		<div id="pix_bloc">
			<h2>Les rencontres !</h2>
			<p>Retrouvez toutes les photos prises lors des rencontres IRCube sur <a href="http://picasaweb.google.fr/ir3album">l'album du réseau</a> !</p>
			<div style="text-align:center;">
				
			</div>
			
		</div>
		
		<div id="linkus_bloc">
			<h2>Aidez-nous !</h2>
			<p>
				Nos services sont gratuits, nous avons besoin de vous pour les maintenir au même niveau de qualité.
				<br /><br />
				Aidez-nous en faisant <a href="/webmasters/link/">pointer un lien</a> vers notre site, ou en intégrant <a href="/staff/">notre staff</a> !
			</p>
		</div>
		
		<div id="partners_bloc">
			<h2>Nos partenaires</h2>
			<ul>
															<li>
							<a href="http://edtech.free.fr/pixel/forum/index.php" title="Le premier forum sur les blogs graphiques">La Brouette</a>
						</li>
																				<li>
							<a href="http://www.defifoot.com" title="Manager de football en ligne">Defifoot</a>
						</li>
																													<li>
							<a href="http://www.weborama.fr" title="Classement quotidien des meilleurs sites francophones">Weborama</a>
						</li>
																																						<li>
							<a href="http://www.poudlard.org" title="Tout sur Harry Potter">Poudlard</a>
						</li>
																				<li>
							<a href="http://www.webrankinfo.com" title="Astuces, conseils et forum référencement">Référencement</a>
						</li>
																					</ul>
		</div>

	</div>
</div>
