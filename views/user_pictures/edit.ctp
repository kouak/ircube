<?php
echo $html->script(array('uploadify/jquery.uploadify', 'uploadify/swfobject.js', 'jquery/jquery.blockUi'), array('once' => true, 'inline' => false));
echo $html->css(array('uploadify/uploadify'), null, array('inline' => false));
?>
<script type="text/javascript">// <![CDATA[
$(document).ready(function() {
	$('#fileInput').uploadify({
		'uploader'  : '/swf/uploadify/uploadify.swf',
		'script'    : '/user_pictures/upload/',
		'cancelImg' : '/img/delete.png',
		'auto'      : true,
		'multi'     : true,
		'folder'    : '/uploads',
		'scriptData': {'<?php echo Configure::read('Session.cookie'); ?>' : '<?php echo $this->Session->id(); ?>'},
		'onError' : upError,
		'onComplete' : upComplete,
	});
	loadDelete();
});

function loadDelete() {
	/* deal with thumbnails */
	$('#thumbnails div.thumbnail').hover(function() {
		var parent_div = $(this);
		var id = $(this).find('img').attr('alt');
		$('<a href="#" id="delete-img" rel="3" style="position:absolute; top:5px; right:5px;"><img src="/img/delete.png" alt="Supprimez cette image" /></a>')
		.prependTo($(this))
		.click(function() {
			$('#delete-img').remove();
			/* Block ui on this element */
			parent_div.block({message: '<img src="/img/ajax-loader-tiny.gif" alt="loading ..."/>'});
			$.ajax({
				type: "POST",
				url: "<?php echo Router::url(array('controller' => 'user_pictures', 'action' => 'delete')); ?>",
				data: "id=" + id,
				dataType: "html", /* IMPORTANT */
				success: function(msg) {
					var i = parseInt(this.data.replace('id=', ''));
					/* Remove image ... */
					$('div.thumbnail img[alt=' + i + ']').parents('div.thumbnail').fadeOut('slow', function() {
						$(this).remove();
					});
				}
			});
			return false;
		});
	}, function() { /* UnHover */ 
		var id = $(this).find('img').attr('alt');
		$('#delete-img').remove();
	});
	
	/* deal with avatar */
	$('div.#avatar > div > div.thumbnail-center > span').hover(function() {
		$('<a href="#" id="delete-img" style="position:absolute; top:5px; right:5px;"><img src="/img/delete.png" alt="Supprimez votre avatar" /></a>'
		+ <?php echo '\'' . 
		$this->Html->link(
			'<img src="/img/edit.png" alt="Modifiez votre avatar" />', 
			array('controller' => 'user_pictures', 'action' => 'avatar_from_gallery'),
			array('escape' => false, 'id' => 'modify-img', 'style' => 'position:absolute; top: 5px; right: 25px;')
		) . '\''; ?>)
		.prependTo($(this));
	}, function() {
		$('#delete-img, #modify-img').remove();
	});
	
}

function loadImage(r) {
	var json = eval('(' + r + ')');
	$.get('<?php echo Router::url(array('controller' => 'user_pictures', 'action' => 'getImageDiv')); ?>' + '/' + json['Attachment']['id'], function(data) {
		$(data).appendTo('#thumbnails').hide().fadeIn();
		$('#noImgInGallery').remove();
		loadDelete(); /* When image is added, load delete button */
	});
}

function upError(a,b,c,d) {
	fancyError(b, d.info);
}

function fancyError(ID, message) {
	$("#fileInput"  + ID + " .percentage").text(' - ' + message);
	alert("Une erreur s'est produite :\n" + message);
}

function upComplete(event,ID,fileObj,response,data) {
	var status, a, r;
	console.log(response);
	a = response.split(':');
	status = a.shift();
	r = a.join(':');
	
	
	if(status == 'ERROR') {
		fancyError(ID, r);
		return false;
	}
	else if(status == 'SUCCESS') {
		// Do fancy stuff here, (add image to gallery)
		loadImage(r);
		return true;
	}
	return false;
}

// ]]></script>
	<h1>Modifiez votre gallerie !</h1>
	<div class="span-12 box">
		<form>
				<input id="fileInput" name="fileInput" type="file" />
		</form>
	</div>
	<?php
	echo $this->Ircube->startBox(array('id' => 'avatar', 'span' => 'span-6 prepend-4', 'color' => 'blue', 'header' => 'h3'));
	echo $this->Ircube->boxTitle(sprintf(__('Votre avatar', true), $AuthUser['username']));
	echo $this->Ircube->startBoxContent();
	$seeMore = '';
	if(!empty($userProfile['UserProfile']['Avatar']['id'])) {
		$seeMore = '<div class="clear"></div>' . 
		$this->Html->link(
			'Supprimer cet avatar',
			array('controller' => 'user_pictures', 'action' => 'gallery', $userProfile['UserProfile']['username'])
		);
	}
	echo $this->Ircube->thumbnailCenterWrap($this->Html->image($this->Ircube->avatar($userProfile['UserProfile'])) . $seeMore, array('style' => 'position:relative;'));
	/* This position: relative; is needed for the hover delete and modify images */
	echo $this->Ircube->endBox();
	?>
	<div class="clear"></div>
	<div id="thumbnails">
	<?php
		if(empty($userProfile['Attachment'])) {
			echo '<p id="noImgInGallery">';
			__('Oops ! Il n\'y a pas encore d\'image dans votre gallerie. Dépêchez vous d\'en ajouter !');
			echo '</p>';
		} else {
			foreach($userProfile['Attachment'] as $pic) {
				echo $ircube->image($medium->webroot('filter' . DS . 's' . DS . $pic['dirname'] . DS . $pic['basename']), array('alt' => $pic['id']));
			}
		}
	?>
	</div>