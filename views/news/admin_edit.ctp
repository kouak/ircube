<div class="news form">
<?php echo $form->create('News', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php if($addnews == true) { __('Ajouter une news'); } else { __('Editer une news'); }?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('newstype_id', array('label' => __('Catégorie', true)));
		echo $form->input('title', array('label' => __('Titre', true)));
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
		echo $form->input('News.published', array('label' => 'Publiée'));
	?>
	</fieldset>
<?php echo $form->end('Envoyer');?>
</div>