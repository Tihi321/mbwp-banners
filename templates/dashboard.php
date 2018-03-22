<div class="wrap">
	<h1>MBWP Banners Dashboard</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Options</a></li>
		<li><a href="#tab-3">Info</a></li>
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">

			<form method="post" action="options.php">
				<?php 
					settings_fields( 'mbwp_banners_settings' );
					do_settings_sections( 'mbwp_banners' );
					submit_button();
				?>
			</form>
			
		</div>

		<div id="tab-3" class="tab-pane">
			<p>This plugin creates 3 extra places for ads, one on top of the website and two on each side.</p>
			<h3>Cache</h3>
			<p>For multiple banners there are 2 modes, with cache on and off. With a cache of WordPress will load one banner on each refresh based on priority, higher priority number higher chances on the ad being shown. With cache on, WordPress will load return all banners, banners will be hidden and javascript will show banner base on priority. WordPress cache plugin caches all html, in order so that only one banner is shown up cache options should be enabled.</p>
			<h3>Adblock</h3>
			<p>On iframe's there is Adblock check, if the iframe is being blocked by ad blockers, the backup image will be shown linked to the ad from ad link field. Javascript checks the opacity of body element inside iframe and if opacity is o, image is shown instead of iframe.With the option "show image only" enabled WordPress will not load iframe, only image from the image field will be shown. If the fields are empty default image will be shown.</p>
			<h3>Boxed Layout</h3>
			<p>Boxed layout option is self explanatory, it as a wrap around the website with max-width of the width field. If the banner option is enabled, the size will only affect banners, as some WordPress themes or plugin may have their own version implemented</p>
			<h3>Developer</h3>
			<p>Tihomir Selak</p>
			<a href="https://www.motionbump.com/" trget="_blank">www.motionbump.com</a>
			<p>For everyone that would like to learn WordPress development I highly recommend to start on <a href="https://www.youtube.com/user/williamprey" target="_blank">Alessandro Castellani's YouTube Channel</a> and by checking his website. <a href="http://www.alecaddd.com/" trget="_blank">http://www.alecaddd.com</a></p>
		</div>
	</div>
</div>