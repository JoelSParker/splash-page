<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="<?= get_stylesheet_directory_uri() ?>/favicon.ico?<?= SplashPage::VERSION ?>" type="images/x-icon" />
		<?php wp_head(); ?>
		<link rel="stylesheet" href="<?= plugin_dir_url(__FILE__) ?>style.css?v=<?= SplashPage::VERSION ?>">
		<style type="text/css">
			h1, h2, h3, h4 {
			    color: <?= get_option('splash_page_h_tags') ?> 
			}

			body {
				background: url(<?= get_option('splash_page_background_image') ?>);
				background: <?= get_option('splash_page_background_color') ?>;
			}

			a, a:hover, a:focus, a:visited {
				color: <?= get_option('splash_page_link_color') ?>;
			}

			<?= get_option('splash_page_inline_styles') ?>
		</style>
	</head>

	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4 vcenter">
					<h1><?= get_option('splash_page_cta') ?></h1>

					<form action="<?= plugin_dir_url(__FILE__) ?>optin.php" method="post">
						<input type="hidden" name="redirect" value="<?= get_option('splash_page_redirect') ?>">
						<input type="hidden" name="page" value="splash-page">

						<div class="form-group">
							<label for="name">Name:</label>
							<input type="name" class="form-control" id="name" name="name">
						</div>

						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" class="form-control" id="email" name="email">
						</div>

						<input type="submit" id="submit" class="btn btn-primary" value="<?= get_option('splash_page_submit_button') ?>">
					</form>
				</div>

				<div class="col-sm-6 col-sm-offset-1 vcenter">
					<p><?= get_option('splash_page_text') ?></p>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row" id="info-bar">
				<div class="col-sm-1">
					<a href="<?= get_option('splash_page_contribute_url') ?>"><div class="button button btn-contribute pull-left">Contribute</div></a>
				</div>

				<div class="pull-right col-sm-11 text-right">
					<h4><a href="<?= get_option('splash_page_site_url') ?>">CONTINUE TO SITE &#10148;</a></h4>
				</div>
			</div>
		</div>
		<!--End Footer-->
		<?php wp_footer(); ?>

		<script>
			<?= get_option('splash_page_custom_js') ?>
		</script>
	</body>
</html>