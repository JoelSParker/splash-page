<?php
	$args = array(
		'post_type'=> 'page',
		'post_status' => 'publish',
		'posts_per_page' => '200',
		'order'    => 'ASC'
	);

	$pages = query_posts($args);
?>
<div class="wrap">
	<h2>Splash Page</h2>

	<?php
	if (isset($_POST['submit']))
		echo '<div id="message" class="updated below-h2"><p>Options Updated.</p></div>';
	?>
	<form name="form" method="post" action="">
		<input type="hidden" name="submit" value="1">
		<table class="form-table">
			<tbody>
				<?php foreach($this->options as $heading => $item): ?>
					<tr>
						<th>
							<h3><?= $heading ?></h3>
						</th>
					</tr>

					<?php foreach($item as $k => $v): ?>
					<tr>
						<th><?= $v['label'] ?></th>
						<td>
						<?php
							if($v['type'] == 'textarea')
								echo sprintf('<textarea name="%s" cols="80" rows="6">%s</textarea>',$k, get_option($k, $v['default']) ?: $v['default']);

							elseif($v['type'] == 'input')
								echo sprintf('<input type="text" name="%s" value="%s">',$k, get_option($k, $v['default']) ?: $v['default']);

							elseif($v['type'] == 'checkbox')
								echo sprintf('<input type="checkbox" name="%s" value="%s" %s>',$k, $val = get_option($k), $val ? 'checked': '');

					endforeach;
					?>

				<?php endforeach; ?>

				<tr>
					<th><input type="submit" class="button-primary"></input></th>
				</tr>
			</tbody>
		</table>
	</form>
</div>