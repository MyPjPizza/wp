<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	
	$Count_WooCommerce 							= 0;
	foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_WooCommerce_Elements as $ElementName => $element) {
		if ($element['deprecated'] == 'false') {
			$Count_WooCommerce++;
		}
	}
?>
<div id="ts-settings-woocommerce" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-info"></i>General Information</div>
		<div class="ts-vcsc-section-content">
			<a class="button-secondary" style="width: 250px; margin: 20px auto 10px auto; text-align: center;" href="http://docs.woothemes.com/document/woocommerce-shortcodes/" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('css/settings/settings-woocommerce.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">WooCommerce Shortcodes</a>
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				Starting with v4.4.0, Visual Composer itself includes a set of elements that can be used to directly embed the shortcodes that are part of WooCommerce with Visual Composer. No extra styling will be applied; all standard shortcodes will be processed
				by WooCommerce directly. Composium - Visual Composer Extensions will add some additional elements and shortcodes to Visual Composer, that will allow you to display WooCommerce products in layouts that are not part of WooCommerce.
			</div>
		</div>
	</div>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-cart"></i>Manage WooCommerce Elements <span class="ts-vcsc-element-count">(<i class="dashicons-image-filter"></i> <?php echo ($Count_WooCommerce); ?>)</span></div>
		<div class="ts-vcsc-section-content">
			<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				While you can prevent individual elements from becoming available to certain user groups (using the "User Group Access Rules" in the settings for the original Visual Composer Plugin), the elements are technically still
				loaded in the background. In order to allow for an improved overall site performance, you can completely disable unwanted elements that are part of Visual Composer Extensions here. Once disabled, the element and associated shortcode will
				not be loaded anymore.
			</div>
			<?php
				echo '<div style="width: 45%; display: inline-block; vertical-align: top; min-width: 275px; margin-right: 5%;">';
					echo '<h4>Custom Shortcodes</h4>';
					echo '<p style="font-size: 12px; text-align: justify;">These elements reflect custom shortcodes that are part of Visual Composer Extensions.</p>';
					foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_WooCommerce_Elements as $ElementName => $element) {
						if (($element['type'] == 'class') && ($element['deprecated'] == 'false')) {
							echo '<div style="margin: 0 0 10px 0;">';
								echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
									echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_woocommerce' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_woocommerce' . $element['setting'] . '" name="ts_vcsc_extend_settings_woocommerce' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
									echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
										echo '<div class="toggle-slide">';
											echo '<div class="toggle-inner">';
												echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
												echo '<div class="toggle-blob"></div>';
												echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';		
							echo '</div>';
						}
					}
				echo '</div>';
				echo '<div style="width: 45%; display: inline-block; vertical-align: top; min-width: 275px; margin-right: 0%;">';
					echo '<h4>Deprecated Shortcodes</h4>';
					echo '<p style="font-size: 12px; text-align: justify;">These elements have been deprecated in favor of other elements.</p>';
					foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_WooCommerce_Elements as $ElementName => $element) {
						if (($element['type'] == 'class') && ($element['deprecated'] == 'true')) {
							echo '<div style="margin: 0 0 10px 0;">';
								echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
									echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_woocommerce' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_woocommerce' . $element['setting'] . '" name="ts_vcsc_extend_settings_woocommerce' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
									echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
										echo '<div class="toggle-slide">';
											echo '<div class="toggle-inner">';
												echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
												echo '<div class="toggle-blob"></div>';
												echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';		
							echo '</div>';
						}
					}
				echo '</div>';
			?>
		</div>
	</div>
</div>
