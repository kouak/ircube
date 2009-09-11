Pas de profil pour le salon <?php echo $channel['Channel']['channel']; ?><br />
<?php
echo $html->link(__('Le créer', true), array('action' => 'create', 'channel' => substr($channel['Channel']['channel'], 1)));
?>