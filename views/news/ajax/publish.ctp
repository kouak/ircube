<?php
if(!empty($news)) {
	echo $this->element('admin/news/news', array('news' => $news));
}
else {
	__('Une erreur s\'est produite');
}
?>