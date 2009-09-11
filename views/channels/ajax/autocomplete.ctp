<?php
$json = array();
if(!empty($channels)) {
	foreach($channels as $channel) {
		$json[] = array('caption' => $channel['Channel']['channel'], 'value' => $channel['Channel']['id']);
	}
}
echo $javascript->Object($json);
?>