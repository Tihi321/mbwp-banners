<?php use Inc\Api\Callbacks\BannersCallbacks;
$banners_callback = new BannersCallbacks();?>
<div class="wrap">
	<h1>Add/Edit Page</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="<?php echo !isset($_POST["edit_post"]) ? 'active' : '' ?>"><a href="#tab-1">List</a></li>
		<li class="<?php echo isset($_POST["edit_post"]) ? 'active' : '' ?>">
			<a href="#tab-2">
				<?php echo isset($_POST["edit_post"]) ? 'Edit' : 'Add' ?> Banner
			</a>
		</li>
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_post"]) ? 'active' : '' ?>">

			<?php 
				$options_top = array();
				$options_left = array();
				$options_right = array();
				$options = get_option( 'mbwp_banners_list' ) ?: array();
				foreach ($options as $option => $values) {
					switch ($values["banner_type"]) {
						case '1':
							$options_top[] = $options[$option];
							break;
						case '2':
							$options_left[] = $options[$option];
							break;
						case '3':
							$options_right[] = $options[$option];
							break;
						
						default:
							break;
					}
					
				}
				echo "<h3>Top</h3>";
				$banners_callback->cptTable($options_top);
				echo "<h3>Left</h3>";
				$banners_callback->cptTable($options_left);
				echo "<h3>Right</h3>";
				$banners_callback->cptTable($options_right);
				
			?>
			
		</div>

		<div id="tab-2" class="tab-pane <?php echo isset($_POST["edit_post"]) ? 'active' : '' ?>">
			<form method="post" action="options.php">
				<?php 
					settings_fields( 'mbwp_banners_list_settings' );
					do_settings_sections( 'mbwp_banners_list_page' );
					submit_button();
				?>
			</form>
		</div>
	</div>
</div>