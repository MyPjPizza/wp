<?php
	global $VISUAL_COMPOSER_EXTENSIONS;

?>

<div id="ts-settings-elements" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-info"></i>General Elements Information</div>
		<div class="ts-vcsc-section-content">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				While you can prevent individual elements from becoming available to certain user groups (using the "User Group Access Rules" in the settings for the original Visual Composer Plugin), the elements are technically still
				loaded in the background. In order to allow for an improved overall site performance, you can completely disable unwanted elements that are part of "Composium - Visual Composer Extensions" here. Once disabled, the element and its
				associated shortcode will not be loaded anymore. <strong>Also, on default, not all elements are activated upon first plugin activation, so please check the list and the select the elements you are planning to use.</strong>
			</div>		
			<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 20px; margin-bottom: 20px; font-size: 13px; font-weight: bold; text-align: justify;">
				Every additional element (or feature) you activate will increase the memory load this add-on is having on your WordPress site and naturally impact overall Visual Composer performance. Please ensure that your
				server is providing sufficient memory to handle all elements and features you are planning on using!
			</div>
			<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify;">If you are using the "User Roles Manager" provided by Visual Composer itself, you MUST assign the new
			elements to the respective user roles that are allowed to use/edit them, using the <a href="<?php echo $visual_composer_roles; ?>" target="_blank">role manager</a> inside the actual Visual Composer plugin settings.</div>
		</div>
	</div>	
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-format-video"></i>How to use Visual Composer's User Roles Manager</div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">				
			<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify;">If you are using the "User Roles Manager" provided by Visual Composer itself, you MUST assign the new
			elements to the respective user roles that are allowed to use/edit them, using the <a href="<?php echo $visual_composer_roles; ?>" target="_blank">role manager</a> inside the actual Visual Composer plugin settings.</div>
			<div style="width: 50%; height: 100%;">
				<div class="ts-video-container">
					<iframe style="width: 100%;" width="100%" height="100%" src="https://www.youtube.com/embed/3PJPMSD3zWU" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>	
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-shield"></i>Standard Elements <span class="ts-vcsc-element-count">(<i class="dashicons-image-filter"></i> <?php echo ($Count_Main); ?>)</span></div>
		<div class="ts-vcsc-section-content">
			<div style="width: 100%; margin-top: 10px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Standard Shortcodes</div>
				<p style="font-size: 12px; text-align: justify;">These are the <?php echo $Count_Main; ?> post type and feature independent elements that are currently fully supported and fully compatible with the current release of Visual Composer.</p>					
				
				<div id="ts-vcsc-manage-elements-all-enable" class="button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Main; ?> Element(s)</div>
				<div id="ts-vcsc-manage-elements-all-disable" class="button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Main; ?> Element(s)</div>
				
				<div class="ts-changelog-generator-tabs" style="margin-top: 10px;">
					<ul class="ts-changelog-generator-tab-links">
						<li id="ts-changelog-generator-tab-trigger1" class="active"><a href="#ts-changelog-generator-tab1"><i class="dashicons-format-gallery"></i><span>Media </span><span style="font-size: 12px;">(<?php echo $Count_Media; ?>)</span></a></li>
						<li id="ts-changelog-generator-tab-trigger2"><a href="#ts-changelog-generator-tab2"><i class="dashicons-googleplus"></i><span>Google </span><span style="font-size: 12px;">(<?php echo $Count_Google; ?>)</span></a></li>
						<li id="ts-changelog-generator-tab-trigger3"><a href="#ts-changelog-generator-tab3"><i class="dashicons-admin-links"></i><span>Buttons & Links </span><span style="font-size: 12px;">(<?php echo $Count_Buttons; ?>)</span></a></li>
						<li id="ts-changelog-generator-tab-trigger4"><a href="#ts-changelog-generator-tab4"><i class="dashicons-backup"></i><span>Counters </span><span style="font-size: 12px;">(<?php echo $Count_Counters; ?>)</span></a></li>
						<li id="ts-changelog-generator-tab-trigger5"><a href="#ts-changelog-generator-tab5"><i class="dashicons-format-aside"></i><span>Posts </span><span style="font-size: 12px;">(<?php echo $Count_Posts; ?>)</span></a></li>
						<li id="ts-changelog-generator-tab-trigger6"><a href="#ts-changelog-generator-tab6"><i class="dashicons-megaphone"></i><span>Titles & Teasers </span><span style="font-size: 12px;">(<?php echo $Count_Titles; ?>)</span></a></li>
						<li id="ts-changelog-generator-tab-trigger7"><a href="#ts-changelog-generator-tab7"><i class="dashicons-feedback"></i><span>Popups & Modals </span><span style="font-size: 12px;">(<?php echo $Count_Popups; ?>)</span></a></li>
						<li id="ts-changelog-generator-tab-trigger8"><a href="#ts-changelog-generator-tab8"><i class="dashicons-admin-appearance"></i><span>Various </span><span style="font-size: 12px;">(<?php echo $Count_Other; ?>)</span></a></li>
						<li id="ts-changelog-generator-tab-trigger9"><a href="#ts-changelog-generator-tab9"><i class="dashicons-warning"></i><span>BETA </span><span style="font-size: 12px;">(<?php echo $Count_Beta; ?>)</span></a></li>
					</ul>	 
					<div class="ts-changelog-generator-tab-content">
						<div id="ts-changelog-generator-tab1" class="ts-changelog-generator-tab-single active clearFixMe" data-group="Media" style="padding-top: 10px;">
							<div class="ts-vcsc-manage-elements-group-buttons">									
								<div id="ts-vcsc-manage-elements-media-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Media; ?> Element(s) in Group "Media"</div>
								<div id="ts-vcsc-manage-elements-media-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Media; ?> Element(s) in Group "Media"</div>
							</div>
							<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
								if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Media')) {
									echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
										echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
											echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
										echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';				
									echo '</div>';
								}
							} ?>
						</div>
						<div id="ts-changelog-generator-tab2" class="ts-changelog-generator-tab-single clearFixMe" data-group="Google" style="padding-top: 10px;">
							<div class="ts-vcsc-manage-elements-group-buttons">									
								<div id="ts-vcsc-manage-elements-google-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Google; ?> Element(s) in Group "Google"</div>
								<div id="ts-vcsc-manage-elements-google-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Google; ?> Element(s) in Group "Google"</div>
							</div>
							<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
								if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Google')) {
									echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
										echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
											echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
										echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';				
									echo '</div>';
								}
							} ?>
						</div>
						<div id="ts-changelog-generator-tab3" class="ts-changelog-generator-tab-single clearFixMe" data-group="Buttons" style="padding-top: 10px;">
							<div class="ts-vcsc-manage-elements-group-buttons">									
								<div id="ts-vcsc-manage-elements-buttons-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Buttons; ?> Element(s) in Group "Buttons & Links"</div>
								<div id="ts-vcsc-manage-elements-buttons-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Buttons; ?> Element(s) in Group "Buttons & Links"</div>
							</div>
							<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
								if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Buttons')) {
									echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
										echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
											echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
										echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';				
									echo '</div>';
								}
							} ?>
						</div>
						<div id="ts-changelog-generator-tab4" class="ts-changelog-generator-tab-single clearFixMe" data-group="Counters" style="padding-top: 10px;">
							<div class="ts-vcsc-manage-elements-group-buttons">									
								<div id="ts-vcsc-manage-elements-counters-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Counters; ?> Element(s) in Group "Counters"</div>
								<div id="ts-vcsc-manage-elements-counters-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Counters; ?> Element(s) in Group "Counters"</div>
							</div>
							<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
								if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Counters')) {
									echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
										echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
											echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
										echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';				
									echo '</div>';
								}
							} ?>
						</div>
						<div id="ts-changelog-generator-tab5" class="ts-changelog-generator-tab-single clearFixMe" data-group="Posts" style="padding-top: 10px;">
							<div class="ts-vcsc-manage-elements-group-buttons">									
								<div id="ts-vcsc-manage-elements-posts-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Posts; ?> Element(s) in Group "Posts"</div>
								<div id="ts-vcsc-manage-elements-posts-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Posts; ?> Element(s) in Group "Posts"</div>
							</div>
							<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
								if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Posts')) {
									echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
										echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
											echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
										echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';				
									echo '</div>';
								}
							} ?>
						</div>
						<div id="ts-changelog-generator-tab6" class="ts-changelog-generator-tab-single clearFixMe" data-group="Titles" style="padding-top: 10px;">
							<div class="ts-vcsc-manage-elements-group-buttons">									
								<div id="ts-vcsc-manage-elements-titles-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Titles; ?> Element(s) in Group "Titles & Teasers"</div>
								<div id="ts-vcsc-manage-elements-titles-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Titles; ?> Element(s) in Group "Titles & Teasers"</div>
							</div>
							<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
								if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Titles')) {
									echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
										echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
											echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
										echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';				
									echo '</div>';
								}
							} ?>
						</div>
						<div id="ts-changelog-generator-tab7" class="ts-changelog-generator-tab-single clearFixMe" data-group="Popups" style="padding-top: 10px;">
							<div class="ts-vcsc-manage-elements-group-buttons">									
								<div id="ts-vcsc-manage-elements-popups-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Popups; ?> Element(s) in Group "Popups & Messages"</div>
								<div id="ts-vcsc-manage-elements-popups-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Popups; ?> Element(s) in Group "Popups & Messages"</div>
							</div>
							<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
								if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Popups')) {
									echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
										echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
											echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
										echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';				
									echo '</div>';
								}
							} ?>
						</div>
						<div id="ts-changelog-generator-tab8" class="ts-changelog-generator-tab-single clearFixMe" data-group="Other" style="padding-top: 10px;">
							<div class="ts-vcsc-manage-elements-group-buttons">									
								<div id="ts-vcsc-manage-elements-other-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Other; ?> Element(s) in Group "Various"</div>
								<div id="ts-vcsc-manage-elements-other-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Other; ?> Element(s) in Group "Various"</div>
							</div>
							<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
								if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Other')) {
									echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
										echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
											echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
										echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';				
									echo '</div>';
								}
							} ?>
						</div>
						<div id="ts-changelog-generator-tab9" class="ts-changelog-generator-tab-single clearFixMe" data-group="BETA" style="padding-top: 10px;">
							<div class="ts-vcsc-manage-elements-group-buttons">									
								<div id="ts-vcsc-manage-elements-other-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Beta; ?> Element(s) in Group "BETA"</div>
								<div id="ts-vcsc-manage-elements-other-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Beta; ?> Element(s) in Group "BETA"</div>
							</div>								
							<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 0px !important; margin-bottom: 30px !important; font-size: 13px; text-align: justify; float: left;">
								The elements listed in this section are still under development, which means there are still limitations in their usage. Usage of these elements is therefore at your own risk as full
								functionality can not (yet) be guaranteed, although elements are usually safe to use. We offer BETA elements because some users requested those elements to be available already now, without
								wanting to wait until an official release occurs.
							</div>								
							<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
								if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'BETA')) {
									echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
										echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
											echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
										echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';				
									echo '</div>';
								}
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-plugins"></i>3rd Party Plugin Elements <span class="ts-vcsc-element-count">(<i class="dashicons-image-filter"></i> <?php echo ($Count_External); ?>)</span></div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div class="clearFixMe" style="margin-top: 10px;">
				<div class="ts-vcsc-info-field ts-vcsc-warning" style="margin-top: 0px; margin-bottom: 20px; font-size: 13px; text-align: justify;">
					This add-on to Visual Composer provides some elements that require additional plugins to work. Those additional plugins are <strong>NOT</strong> part of this add-on and must be purchased separately from the respective author.
				</div>
				<div style="font-weight: bold; font-size: 14px; margin: 0;">3rd Party Shortcodes</div>
				<p style="font-size: 12px; text-align: justify;">These <?php echo $Count_External; ?> elements require additional (not included) plugins or are just for demo purposes.</p>
				<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
					if ($element['type'] == 'external') {
						echo '<div style="margin: 0 0 10px 0;">';
							echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
								echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
							echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';	
						echo '</div>';
					}
				} ?>
			</div>
		</div>
	</div>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-businessman"></i>Developer Demo Shortcodes + Elements <span class="ts-vcsc-element-count">(<i class="dashicons-image-filter"></i> <?php echo ($Extra_Demos); ?>)</span></div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div class="ts-vcsc-info-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				The following elements are usually reserved for developers that need to display a preview of certain features this plugin provides for, such as icon fonts, CSS3 animations and others. As such, those elements are usually
				not used on end-user pages, but can be enabled here nevertheless.
			</div>
			<div class="clearFixMe" style="margin-top: 20px; margin-bottom: 0px;">
				<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Demos as $ElementName => $element) {
					if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['base'] != '') && ($element['group'] == 'Demos')) {
						echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
							echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
								echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_demo' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_demo' . $element['setting'] . '" name="ts_vcsc_extend_settings_demo' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
							echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_demo' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(1)</span></label>';				
						echo '</div>';
					}
				} ?>
			</div>
			<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				The following setting will only enable some additional developer shortcodes that are not (yet) associated with any elements in Visual Composer.
			</div>
			<div class="clearFixMe" style="margin-top: 10px; margin-bottom: 0px;">
				<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Demos as $ElementName => $element) {
					if (($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['base'] == '') && ($element['group'] == 'Demos')) {
						echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
							echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
								echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_demo' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_demo' . $element['setting'] . '" name="ts_vcsc_extend_settings_demo' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
							echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_demo' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(0)</span></label>';				
						echo '</div>';
					}
				} ?>
			</div>	
		</div>
	</div>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-dismiss"></i>Deprecated (Retired) Elements <span class="ts-vcsc-element-count">(<i class="dashicons-image-filter"></i> <?php echo ($Count_Deprecated); ?>)</span></div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div class="clearFixMe" style="margin-top: 10px;">
				<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 0px; margin-bottom: 20px; font-size: 13px; text-align: justify;">
					From time to time, it will become necessary to "retire" or "deprecate" elements in favor of a newer and better version. You will still be able to use those "old" elements (provided they are enabled below), but
					it is highly recommended to switch over to the "new" element that replaced the "old" one.
				</div>
				<div style="width: 48%; float: left; min-width: 360px; margin-right: 2%; margin-top: 10px;">
					<div style="font-weight: bold; font-size: 14px; margin: 0;">Deprecated Shortcodes</div>
					<p style="font-size: 12px; text-align: justify;">These <?php echo $Count_Deprecated; ?> elements have been deprecated in favor of other elements; you should use the new versions instead.</p>
					<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
						if (($element['deprecated'] == 'true') && ($element['type'] != 'external')) {
							echo '<div style="margin: 0 0 10px 0;">';
								echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
									echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
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
								echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '" <span class="ts-vcsc-element-count">(' . (intval($element['children']) + 1) . ')</span></label>';	
							echo '</div>';
						}
					} ?>
				</div>
				<div style="width: 48%; float: left; min-width: 360px; margin-left: 2%; margin-top: 10px;">
					<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 20px; margin-bottom: 20px; font-size: 13px; text-align: justify;">
						Provided a deprecated element is enabled, using the controls shown on the left, any such element already existing in any page or post will still be rendered on the frontend and can still be edited with
						Visual Composer; but such an element can <strong>NOT</strong> be added as a new element to a page or post anymore. If deprecated elements should be available to be added as new elements to a page or post, use the control below.
					</div>					
					<div style="margin-top: 20px;">
						<div style="font-weight: bold; font-size: 14px; margin: 0;">Deprecated Elements in VC's "Add Element" Panel:</div>
						<p style="font-size: 12px;">Define if the deprecated elements on the left should be shown in the "Add Element" panel in Visual Composer:</p>
						<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_allowDeprecated == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
							<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_allowDeprecated" class="toggle-check ts_vcsc_extend_settings_allowDeprecated" name="ts_vcsc_extend_settings_allowDeprecated" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_allowDeprecated); ?>/>
							<div class="toggle toggle-light" style="width: 80px; height: 20px;">
								<div class="toggle-slide">
									<div class="toggle-inner">
										<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_allowDeprecated == 1 ? 'active' : ''); ?>">Yes</div>
										<div class="toggle-blob"></div>
										<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_allowDeprecated == 0 ? 'active' : ''); ?>">No</div>
									</div>
								</div>
							</div>
						</div>
						<label class="labelToggleBox" for="ts_vcsc_extend_settings_allowDeprecated">Show Deprecated Elements in "Add Element" Panel</label>
					</div>	
					
				</div>
			</div>
		</div>
	</div>	
</div>