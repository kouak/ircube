<script type="text/javascript">
function preview(img, selection)
{
	var scaleX = 100 / (selection.width || 1);
	var scaleY = 100 / (selection.height || 1); 

	$('#avatarvalidation img').css({
		width: Math.round(scaleX * img.width) + 'px',
		height: Math.round(scaleY * img.height) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}

$(function() {
	$('div.box').corners("10px bottom");
	$('#avatarareaselect h1, #avatarvalidation h1').corners("10px top");
});

$(window).load(function () {
	$('#fullsize').imgAreaSelect({ aspectRatio: '1:1', onSelectChange: preview });
});
</script>
<?php
$html->css(array('user_pictures/avatarify'), null, array('inline' => false));
$javascript->link('jquery/jquery.imgareaselect.js', false);
echo $form->create(null, array('url' => $this->here));
echo $form->hidden('Avatar.x1', array("value" => "0", "id"=>"x1"));
echo $form->hidden('Avatar.y1', array("value" => "0", "id"=>"y1"));
echo $form->hidden('Avatar.w', array("value" => "0", "id"=>"w"));
echo $form->hidden('Avatar.h', array("value" => "0", "id"=>"h"));
?>
<div id="avatarareaselect" class="span-14 push-1">
				<h1>Sélectionnez une partie de votre image</h1>
				<div class="box">
					<?php echo $html->image($medium->webroot('filter' . DS . 'l' . DS . $Attachment['Attachment']['dirname'] . DS . $Attachment['Attachment']['basename']), array('id' => 'fullsize'));?>
				</div>
</div>
<div id="avatarvalidation" class="span-6 push-1">
	<h1>Créez votre avatar</h1>
	<div class="box">
		<?php
			echo $ircube->thumbnailWrap($html->image($medium->webroot('filter' . DS . 'l' . DS . $Attachment['Attachment']['dirname'] . DS . $Attachment['Attachment']['basename'])));
			echo $form->submit('Done', array("id"=>"save_thumb"));
		?>
	</div>

</div>
<?php
echo $form->end();
?>