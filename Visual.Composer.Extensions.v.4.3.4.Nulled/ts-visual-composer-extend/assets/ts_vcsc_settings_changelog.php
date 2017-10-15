<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
?>
<div id="ts-settings-changelog" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-media-text"></i>Changelog</div>
		<div class="ts-vcsc-section-content">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				The plugin is constantly evolving and adding new features. The listing below is a summary of all changes and additions so far.
			</div>	
			<?php
				$url_gets		= ini_get('allow_url_fopen');
				$url_site 		= get_site_url();
				$url_file		= TS_VCSC_GetResourceURL('Changelog.txt');
				if (strpos($url_file, $url_site) !== false) {
					$url_final	= $url_file;
				} else {
					$url_final	= $url_site . $url_file;
				}
				if ($url_gets == 1) {
					$changelog 		= file_get_contents($url_final, true);
					echo nl2br(str_replace('<br/>', PHP_EOL, $changelog));
				} else {
					echo 'Your site setup does not allow the usage of "allow_url_fopen" and so the changelog file could not be loaded. You can find the full and official changelog
					<a href="http://helpdesk.tekanewascripts.com/changelog-composium-visual-composer-extensions/" target="_blank">here</a>.';
				}
			?>
		</div>
	</div>
</div>