<div class="filter">
	<?php
		foreach($filterLetters as $letter => $state) {
			if($state === false) {
				echo $letter;
			} elseif ($state === true) {
				echo $html->link($letter, array('controller' => $this->params['controller'], 'action' => $this->params['action'], 'filter' => $letter));
			} elseif($state == 'active') {
				echo '<span class="active"><b>' . $html->link($letter, array('controller' => $this->params['controller'], 'action' => $this->params['action'], 'filter' => $letter)) . '</b></span>';
			}
			echo ' ';
		}
	?>
</div>