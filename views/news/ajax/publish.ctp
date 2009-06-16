<?php
if($news) {
	echo $this->element('news/news_admin', array('news' => $news));
}
else {
	__('Une erreur s\'est produite');
}
?>