<div class="news form">
<?php
if($addnews == true) { $legend =  __('Ajouter une news', true); } else { $legend = __('Editer une news', true); }

		echo $uniForm->create('News', array('action' => 'edit', 'fieldset' => array('legend' => $legend, 'blockLabels' => true)));
		echo $uniForm->input('id');
		echo $uniForm->input('newstype_id', array('label' => __('Catégorie', true)));
		echo $uniForm->input('title', array('label' => __('Titre', true)));
        echo $tinymce->input('content', array('label' => false, 'rows' => '30'), array(  
		         'theme' => 'advanced',                                 
		         "plugins" => "safari,style,paste,directionality,visualchars,nonbreaking,xhtmlxtras,inlinepopups,emotions", 
		          "theme_advanced_buttons1" => "undo,redo,|,bold,italic,strikethrough,|,formatselect,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,|,charmap,code,|,emotions", 
		        "theme_advanced_buttons2"=> "", 
		        "theme_advanced_buttons3" => "", 
		         "theme_advanced_toolbar_location" => "top", 
		         "theme_advanced_toolbar_align" => "left", 
		         "theme_advanced_statusbar_location" => "bottom", 
		         "theme_advanced_resizing" => true,
				 'language' => 'fr',
				 'width' => '100%',

		        ));
		echo $uniForm->input('News.published', array('label' => 'Publiée'));
		echo $uniForm->end('Envoyer');
?>
</div>