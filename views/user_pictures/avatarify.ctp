<script type="text/javascript">
function preview(img, selection)
{
	var scaleX = 100 / selection.width;
	var scaleY = 100 / selection.height;

	$('#fullsize + div > img').css({
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

$(document).ready(function () {
	$('<div id="avatar-preview"><img src="' + $('#fullsize').attr('src') + '" style="position: relative;" /></div>')
	.css({
		float: 'left',
		position: 'relative',
		overflow: 'hidden',
		width: '100px',
		height: '100px'
	})
	.insertAfter($('#fullsize'));
});

$(window).load(function () {
	$('#fullsize').imgAreaSelect({ aspectRatio: '1:1', onSelectChange: preview });
});


</script>
<?php
$javascript->link('jquery/jquery.imgareaselect.js', false);
echo $form->create(null, array('url' => $this->here));
echo $form->hidden('x1', array("value" => "0", "id"=>"x1"));
echo $form->hidden('y1', array("value" => "0", "id"=>"y1"));
echo $form->hidden('w', array("value" => "0", "id"=>"w"));
echo $form->hidden('h', array("value" => "0", "id"=>"h"));
echo $html->image($html->webroot(IMAGES_URL . DS . 'upload' . DS . $UserPicture['UserPicture']['filename']), array('id' => 'fullsize'));
echo $form->submit('Done', array("id"=>"save_thumb")); 
echo $form->end();
?>