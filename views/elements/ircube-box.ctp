<?php
echo $html->css(array('ircube-boxes'), null, array('inline' => false));
$defaults = array(
	'header' => 'h1', /* false, h1, h2, h3 */
	'color' => '', /* Blue, orange, green */
	'span' => '', /* blueprint class */
	'id' => false, /* maindiv id */
);
if(isset($options)) {
	$options = am($defaults, $options);
} else {
	$options = $defaults;
}
$noheader = '';
if(!isset($title) || empty($title) || $options['header'] == false) {
	$options['header'] = false;
	$noheader = ' noheader';
}
?>
<div <?php if($options['id'] != false) { echo 'id="' . $options['id'] . '" '; } ?>class="<?php echo $options['span']; ?> ircube-box">
	<?php
		if($options['header'] != false) {
			echo '<' . $options['header'] . ' class="' . $options['color'] . '">' . $title . '</' . $options['header'] . '>';
		}
	?>
	<div class="box<?php echo ' ' . $options['color'] . $noheader; ?>">
		<?php echo $content; ?>
	</div>
</div>
