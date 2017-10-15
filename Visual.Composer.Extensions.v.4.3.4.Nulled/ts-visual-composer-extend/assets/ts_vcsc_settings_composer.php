<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
?>

<div id="ts-settings-composer" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-welcome-view-site"></i>Element Preview Settings</div>
		<div class="ts-vcsc-section-content">
			<div style="margin-top: 10px; margin-bottom: 10px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Show Live Preview in Backend Editor:</div>
				<p style="font-size: 12px;">Define if the plugin should render a live preview of basic elements when using the backend editor:</p>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					For some more basic element that don't have any dependencies on JavaScript routines, the plugin can create a live preview of how the element would look like in the frontend while editing in the backend editor.
					Additional attributes like links or CSS3 animations will of course not be shown, just a graphic rendering of the element. Additional stylesheets (CSS) will have to be loaded to define element styling.
				</div>	
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_backendPreview == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_backendPreview" class="toggle-check ts_vcsc_extend_settings_backendPreview" name="ts_vcsc_extend_settings_backendPreview" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_backendPreview); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_backendPreview == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_backendPreview == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_backendPreview">Show Live Preview</label>
			</div>			
			<div style="margin-top: 30px; margin-bottom: 10px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Show Preview Images in Backend Editor:</div>
				<p style="font-size: 12px;">Define if the plugin should show preview images for all elements using images, or just the image ID when editing a page in the back-end editor:</p>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					By default, the plugin will always show a thumbnail preview image for all of its elements that can utilize images. If you have many of those elements on one site, it can slow down loading times while editing on the
					backend as the thumbnail for each image has to be loaded individually via Ajax request. If you prefer, you can therefore disable that preview and you will be provided with the WordPress image ID number instead.
					This setting will not affect the live preview rendering of basic elements as defined above.
				</div>	
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_previewImages == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_previewImages" class="toggle-check ts_vcsc_extend_settings_previewImages" name="ts_vcsc_extend_settings_previewImages" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_previewImages); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_previewImages == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_previewImages == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_previewImages">Show Preview Images</label>
			</div>
		</div>		
	</div>	
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-tools"></i>Element Setting Panels</div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div style="margin-top: 20px; margin-bottom: 10px; display: block;">
				<h3>Visual Icon Selector:</h3>
				<p style="font-size: 12px;">Define if the plugin should provide you with a visual icon selector for elements, or if you want to manually enter the icon class name:</p>				
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					While the visual icon selector is more convenient to use as you immediately know how the icon looks like, it might slow down your site if you have too many icons (icon fonts) activated as it takes more time
					to create the visual preview of 1,000+ icons, than it does for 200 icons. In those cases, you can disable the visual icon selector and instead provide your icon of choice by entering its class name.
				</div>	
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_visualSelector == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " data-native="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal; ?>" id="ts_vcsc_extend_settings_visualSelector" class="toggle-check ts_vcsc_extend_settings_visualSelector" name="ts_vcsc_extend_settings_visualSelector" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_visualSelector); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_visualSelector == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_visualSelector == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_visualSelector">Use Visual Icon Selector</label>
			</div>	
			<div id="ts_vcsc_extend_settings_visualSelector_true" data-native="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal; ?>" style="margin-top: 30px; margin-bottom: 10px; margin-left: 25px; display: <?php echo ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($ts_vcsc_extend_settings_visualSelector == 1)) ? "block;" : "none;"); ?>">
				<h4>Use VC Native Icon Selector:</h4>
				<p style="font-size: 12px;">Define if the plugin should use the native icon selector that comes with Visual Composer (v4.4.0+):</p>				
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					This add-on included a visual icon selector from its very first release, while Visual Composer itself didn't have such feature, until the release of v4.4.0. To keep things uniform, this add-on will use the
					native icon selector that is now part of Visual Composer, but you can switch back to the custom version we used before, if you desire to do so.
				</div>	
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_nativeSelector == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_nativeSelector" class="toggle-check ts_vcsc_extend_settings_nativeSelector" name="ts_vcsc_extend_settings_nativeSelector" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_nativeSelector); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_nativeSelector == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_nativeSelector == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_nativeSelector">Use VC Native Icon Selector</label>
			</div>
			<div id="ts_vcsc_extend_settings_nativeSelector_true" style="margin-top: 20px; margin-bottom: 20px; margin-left: 50px; display: <?php echo ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($ts_vcsc_extend_settings_visualSelector == 1) && ($ts_vcsc_extend_settings_nativeSelector == 1)) ? "block;" : "none;"); ?>">
				<h4>Number of Icons per Page:</h4>
				<p style="font-size: 12px;">Define the number of icons that should be shown per page when using the icon picker:</p>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					The more icons you are showing per page, the slower the icon picker element will initially render, as it takes more time to build a visual preview of 200 icons, than it would for 1,000. The limit set here will
					only apply to the native icon pickers utilized by this add-on; it will not transfer to the same type of icon picker used by Visual Composer itself or other add-ons.
				</div>	
				<div class="ts-nouislider-input-slider" style="float: left; display: block; width: 100%; margin-bottom: 20px;">
					<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_nativePaginator" id="ts_vcsc_extend_settings_nativePaginator" class="ts_vcsc_extend_settings_nativePaginator ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="50" max="1000" step="1" value="<?php echo $ts_vcsc_extend_settings_nativePaginator; ?>"/>
					<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">Icons</span>
					<div id="ts_vcsc_extend_settings_nativePaginator_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $ts_vcsc_extend_settings_nativePaginator; ?>" data-min="50" data-max="1000" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
				</div>
			</div>
			<div style="display: block; margin-top: 10px; margin-bottom: 10px; width: 100%; float: left;">
				<h3>Numeric Slider Inputs (NoUiSlider):</h3>
				<p style="font-size: 12px;">For most numeric inputs the plugin provides for in element settings, a slider for faster value setting is provided:</p>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					Whenever possible, this plugin will render numeric inputs in a layout that allows for multiple ways of setting the value (manual input, slider or plus/minus buttons). By default, the plugin will also render
					a scale beneath the slider to show the range of possible values, as well as a tooltip for the slider to showcase the defined value. Both those features can be disabled if you prefer a less cluttered layout.
				</div>
				<div style="margin-top: 0px; margin-bottom: 10px;">
					<h4>Show Tooltip:</h4>
					<p style="font-size: 12px;">Define if the numeric input slider should show a tooltip above the slider, highlighting the currently selected value:</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_nouisliderTooltip == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_nouisliderTooltip" class="toggle-check ts_vcsc_extend_settings_nouisliderTooltip" name="ts_vcsc_extend_settings_nouisliderTooltip" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_nouisliderTooltip); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_nouisliderTooltip == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_nouisliderTooltip == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_nouisliderTooltip">Show Tooltip Above Slider</label>
				</div>
				<img style="width: 100%; max-width: 700px; height: auto; margin: 20px auto; border: 1px solid #cccccc;" src="<?php echo TS_VCSC_GetResourceURL('images/other/parameter_nouislider.jpg'); ?>">
				<div style="margin-top: 0px; margin-bottom: 10px;">
					<h4>Show Pips / Scale:</h4>
					<p style="font-size: 12px;">Define if the numeric input slider should show a scale below the slider, indicating the range of allowable values and main steps:</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_nouisliderPips == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_nouisliderPips" class="toggle-check ts_vcsc_extend_settings_nouisliderPips" name="ts_vcsc_extend_settings_nouisliderPips" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_nouisliderPips); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_nouisliderPips == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_nouisliderPips == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_nouisliderPips">Show Pips / Scale Below Slider</label>
				</div>
			</div>
			<div style="display: block; margin-top: 10px; margin-bottom: 10px; width: 100%;">
				<h3>Advanced Link Selector:</h3>
				<p style="font-size: 12px;">Define if the plugin should provide you with an advanced link selector, based on page/post ID, instead of the standard one that is provided by Visual Composer:</p>				
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					By default, this plugin will use the standard link selector that is part of Visual Composer, which is usually sufficient and faster. But if for some reason, you are frequently changing page/post names and/or slugs, which would
					also change the permalink to that page or post, rendering the link created by the standard link selector invalid, we provide our advanced link selector as an alternative. Instead of using the last known permalink directly,
					the advanced link selector will use the numeric page/post ID as basis. That will allow links created with the advanced link picker to always be current, as long as you don't change the numeric page/post ID number.
				</div>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_linkerEnabled == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_linkerEnabled" class="toggle-check ts_vcsc_extend_settings_linkerEnabled" name="ts_vcsc_extend_settings_linkerEnabled" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_linkerEnabled); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_linkerEnabled == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_linkerEnabled == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_linkerEnabled">Use Advanced Link Selector</label>
			</div>
			<div id="ts_vcsc_extend_settings_linker_true" style="margin-top: 20px; margin-bottom: 10px; margin-left: 25px; <?php echo ($ts_vcsc_extend_settings_linkerEnabled == 0 ? 'display: none;' : 'display: block;'); ?>">
				<div style="margin-top: 0px; margin-bottom: 10px;">
					<h4>Show Standard Posts:</h4>
					<p style="font-size: 12px;">Define if the link selector should also show a listing of all standard WordPress posts, aside from pages:</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_linkerPosts == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_linkerPosts" class="toggle-check ts_vcsc_extend_settings_linkerPosts" name="ts_vcsc_extend_settings_linkerPosts" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_linkerPosts); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_linkerPosts == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_linkerPosts == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_linkerPosts">Show Standard Posts Listing</label>
				</div>				
				<div style="margin-top: 0px; margin-bottom: 10px;">
					<h4>Show Custom Posts:</h4>
					<p style="font-size: 12px;">Define if the link selector should also show a listing of custom WordPress posts, aside from pages (custom posts must be registered as public, queryable and searchable):</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_linkerCustom == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_linkerCustom" class="toggle-check ts_vcsc_extend_settings_linkerCustom" name="ts_vcsc_extend_settings_linkerCustom" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_linkerCustom); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_linkerCustom == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_linkerCustom == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_linkerCustom">Show Custom Posts Listing</label>
				</div>				
				<div style="margin-top: 10px; margin-bottom: 10px; width: 100%;">
					<h4>LazyLoad Offset:</h4>
					<p style="font-size: 12px;">Define the lazyload offset (interval) at which more pages/posts should be added to the link selector once you scroll to the end of the current list:</p>
					<div class="ts-nouislider-input-slider" style="float: left; display: block; width: 100%">
						<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_linkerOffset" id="ts_vcsc_extend_settings_linkerOffset" class="ts_vcsc_extend_settings_linkerOffset ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="10" max="99" step="1" value="<?php echo $ts_vcsc_extend_settings_linkerOffset; ?>"/>
						<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">Links</span>
						<div id="ts_vcsc_extend_settings_linkerOffset_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $ts_vcsc_extend_settings_linkerOffset; ?>" data-min="10" data-max="99" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
					</div>
				</div>
				<div style="margin-top: 20px; margin-bottom: 10px;">
					<h4>Order By Criteria</h4>
					<p>Please define which criteria should be used to order the pages or post in the link selector:</p>
					<label for="ts_vcsc_extend_settings_linkerOrderby" class="ts_vcsc_extend_settings_defaultLightbox">Page/Post Order By Criteria:</label>
					<select id="ts_vcsc_extend_settings_linkerOrderby" name="ts_vcsc_extend_settings_linkerOrderby" style="width: 250px; margin-left: 20px;">
						<option value="title" <?php echo selected('title', $ts_vcsc_extend_settings_linkerOrderby); ?>>Page/Post Title</option>
						<option value="date" <?php echo selected('date', $ts_vcsc_extend_settings_linkerOrderby); ?>>Page/Post Publish Date</option>
						<option value="modified" <?php echo selected('modified', $ts_vcsc_extend_settings_linkerOrderby); ?>>Page/Post Modify Date</option>
						<option value="id" <?php echo selected('id', $ts_vcsc_extend_settings_linkerOrderby); ?>>Page/Post ID</option>
						<option value="author" <?php echo selected('author', $ts_vcsc_extend_settings_linkerOrderby); ?>>Page/Post Author</option>
					</select>
				</div>
				<div style="margin-top: 20px; margin-bottom: 10px;">
					<h4>Order Direction</h4>
					<p>Please define which direction should be used to order the pages or post in the link selector:</p>
					<label for="ts_vcsc_extend_settings_linkerOrder" class="ts_vcsc_extend_settings_defaultLightbox">Page/Post Order Direction:</label>
					<select id="ts_vcsc_extend_settings_linkerOrder" name="ts_vcsc_extend_settings_linkerOrder" style="width: 250px; margin-left: 20px;">
						<option value="ASC" <?php echo selected('ASC', $ts_vcsc_extend_settings_linkerOrder); ?>>Ascending</option>
						<option value="DESC" <?php echo selected('DESC', $ts_vcsc_extend_settings_linkerOrder); ?>>Descending</option>
					</select>
				</div>
			</div>
		</div>		
	</div>
	<?php
		if (TS_VCSC_CheckUserRole(array('administrator'))) {
			if ((function_exists('vc_enabled_frontend')) && (function_exists('vc_disable_frontend'))) {
	?>
				<div class="ts-vcsc-section-main">
					<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-customizer"></i>Frontend Editor Usage</div>
					<div class="ts-vcsc-section-content slideFade" style="display: none;">
						<?php
							echo '<div style="margin-top: 10px; margin-bottom: 10px;">';
								echo '<div style="font-weight: bold; font-size: 14px; margin: 0;">Enable Frontend Editor:</div>';
								echo '<p style="font-size: 12px;">Define if the Frontend-Editor for Visual Composer should be available or not:</p>';
								echo '<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify;">';
									echo 'You can disable the Frontend-Editor for Visual Composer by using the option below. <strong>This setting might not work if your theme or another plugin is applying a contradicting setting at
									a later time during the page creation process. </strong>Even with the Frontend-Editor enabled, we always recommend editing pages via the default backend editor as that
									is the way WordPress intends pages to be edited. Due to the complexity of some of our elements, we also can not guaranty full functionality of the Frontend-Editor since that editor is designed
									to handle the basic elements that are native to Visual Composer, but is still not able to fully support more complex elements.';
								echo '</div>';
								echo '<div class="ts-switch-button ts-composer-switch" data-value="' . ($ts_vcsc_extend_settings_frontendEditor == 1 ? 'true' : 'false') . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
									?> <input type="checkbox" style="display: none;" id="ts_vcsc_extend_settings_frontendEditor" class="toggle-check ts_vcsc_extend_settings_frontendEditor" name="ts_vcsc_extend_settings_frontendEditor" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_frontendEditor); ?>/> <?php
									echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
										echo '<div class="toggle-slide">';
											echo '<div class="toggle-inner">';
												echo '<div class="toggle-on ' . ($ts_vcsc_extend_settings_frontendEditor == 1 ? 'active' : '') . '">Yes</div>';
												echo '<div class="toggle-blob"></div>';
												echo '<div class="toggle-off ' . ($ts_vcsc_extend_settings_frontendEditor == 0 ? 'active' : '') . '">No</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_frontendEditor">Enable Frontend-Editor</label>';
							echo '</div>';
						?>	
					</div>		
				</div>
	<?php
			}
		}
	?>
</div>