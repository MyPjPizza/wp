<?php
	global $VISUAL_COMPOSER_EXTENSIONS;

?>

<div id="ts-settings-posttypes" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-format-aside"></i>Manage Element Custom Post Types <span class="ts-vcsc-element-count">(<i class="dashicons-image-filter"></i> <?php echo ($Count_Types); ?>)</span></div>
		<div class="ts-vcsc-section-content">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				Starting with version 2.0, Visual Composer Extensions introduced custom post types, to be used for some of the elements and for more complex layouts. If your theme or another plugin already provides a similiar post
				type (i.e. a post type for "teams"), you can disable the corresponding custom post type that comes with Visual Composer Extensions. Disabling a custom post type will also disable the corresponding Visual Composer elements
				and shortcodes associated with the post type. <strong>The custom post types listed below will provide you with up tp <?php echo $Count_Types; ?> additional elements in Visual Composer.</strong>
			</div>				
			<?php
				if ((version_compare('1.2.0', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesClass, '>=')) && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesInternal == "false")) {
					echo '<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 20px; margin-bottom: 20px; font-size: 13px; font-weight: bold; color: red; text-align: justify;">';
						echo 'Another plugin or your theme is loading an OUTDATED version (v' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesClass . ') of the PHP helper class "Custom Metaboxes and Fields", which is
						used to create the custom post types below. Functionality of our custom post types can not be guaranteed with the outdated version your WordPress is currently using.';
					echo '</div>';
				} else if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesInternal == "false") {
					echo '<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 20px; margin-bottom: 20px; font-size: 13px; font-weight: bold; text-align: justify;">';
						echo 'Another plugin or your theme is already loading the PHP helper class "Custom Metaboxes and Fields" (v' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesClass . '), which is
						used to create the custom post types below. Please ensure that the version loaded is not modified or older than v1.2.0 as functionality of our custom post types can otherwise not be guaranteed.';
					echo '</div>';
				}
			?>
			<div style="margin-top: 20px; display: <?php echo ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_posttypeTimeline', 1) == 0)) ? "none;" : "block;"); ?>">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Visual Composer Timeline:</div>
				<p style="font-size: 12px;">Enable or disable the custom post type "VC Timeline":</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customTimelines == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customTimelines" class="toggle-check ts_vcsc_extend_settings_customTimelines" name="ts_vcsc_extend_settings_customTimelines" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customTimelines); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customTimelines == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customTimelines == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_customTimelines">Enable "VC Timeline" Post Type <span class="ts-vcsc-element-count">(<?php echo $Post_Timeline; ?>)</span></label>			
			</div>		
			<div style="margin-top: 20px; display: <?php echo ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_posttypeTeam', 1) == 0)) ? "none;" : "block;"); ?>">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Visual Composer Team:</div>
				<p style="font-size: 12px;">Enable or disable the custom post type "VC Team":</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customTeam == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customTeam" class="toggle-check ts_vcsc_extend_settings_customTeam" name="ts_vcsc_extend_settings_customTeam" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customTeam); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customTeam == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customTeam == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_customTeam">Enable "VC Team" Post Type <span class="ts-vcsc-element-count">(<?php echo $Post_Team; ?>)</span></label>
			</div>
			<div style="margin-top: 20px; display: <?php echo ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_posttypeTestimonial', 1) == 0)) ? "none;" : "block;"); ?>">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Visual Composer Testimonials:</div>
				<p style="font-size: 12px;">Enable or disable the custom post type "VC Testimonials":</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customTestimonial == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customTestimonial" class="toggle-check ts_vcsc_extend_settings_customTestimonial" name="ts_vcsc_extend_settings_customTestimonial" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customTestimonial); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customTestimonial == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customTestimonial == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_customTestimonial">Enable "VC Testimonials" Post Type <span class="ts-vcsc-element-count">(<?php echo $Post_Testimonial; ?>)</span></label>
			</div>					
			<div style="margin-top: 20px; display: <?php echo ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_posttypeSkillset', 1) == 0)) ? "none;" : "block;"); ?>">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Visual Composer Skillsets:</div>
				<p style="font-size: 12px;">Enable or disable the custom post type "VC Skillsets":</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customSkillset == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customSkillset" class="toggle-check ts_vcsc_extend_settings_customSkillset" name="ts_vcsc_extend_settings_customSkillset" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customSkillset); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customSkillset == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customSkillset == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_customSkillset">Enable "VC Skillsets" Post Type <span class="ts-vcsc-element-count">(<?php echo $Post_Skillsets; ?>)</span></label>			
			</div>	
			<div style="margin-top: 20px; display: <?php echo ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_posttypeLogo', 1) == 0)) ? "none;" : "block;"); ?>">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Visual Composer Logos:</div>
				<p style="font-size: 12px;">Enable or disable the custom post type "VC Logos":</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customLogo == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customLogo" class="toggle-check ts_vcsc_extend_settings_customLogo" name="ts_vcsc_extend_settings_customLogo" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customLogo); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customLogo == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customLogo == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_customLogo">Enable "VC Logos" Post Type <span class="ts-vcsc-element-count">(<?php echo $Post_Logo; ?>)</span></label>			
			</div>				
			<div style="height: 0px; width: 100%; margin: 0 0 10px 0; padding: 0;"></div>
		</div>
	</div>
	<?php if ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_posttypeWidget', 1) == 1)) || (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginExtended == "false"))) { ?>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-welcome-widgets-menus"></i>Widgets + Template Builder Post Type (BETA) <span class="ts-vcsc-element-count">(<i class="dashicons-image-filter"></i> <?php echo ($Post_Widget); ?>)</span></div>
			<div class="ts-vcsc-section-content slideFade" style="display: none;">
				<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					The custom post type "VC Widgets" will allow you to use any Visual Composer or add-on element when creating its content, which can then be shown in any sidebar via corresponding widget. The post type can also
					be used to create a template for an element, which can then be used anywhere else where Visual Composer is enabled, simply by using the dedicated "TS VC Widgets Output (BETA)" element. That way, any changes
					made to the template, will automatically transfer to all pages and posts that use that template.<br/><br/>
					This post type, unlike the ones above, does not have any external dependencies. Any content created with this post type can only be edited with the standard WordPress backend editor and will not be
					available in the Visual Composer frontend editor, once shown in a sidebar or via the dedicated element, since the frontend editor does not provide access to widget content. Whene editing a single "VC Widgets"
					post type directly, the frontend editor will be available, however. In general, this feature is still considered to be in BETA mode!
				</div>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					Please be aware that Visual Composer itself is NOT designed to be used in a sidebar, as WordPress is treating sidebar and main post/page content differently when rendering a page. As such, certain limitations
					will apply to elements that are used in a sidebar via widget. Please see the usage information in the custom post type "VC Widgets".
				</div>	
				<div style="margin-top: 20px; margin-bottom: 20px;">
					<div style="font-weight: bold; font-size: 14px; margin: 0;">Visual Composer Widgets:</div>
					<p style="font-size: 12px;">Enable or disable the custom post type "VC Widgets":</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customWidgets == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customWidgets" class="toggle-check ts_vcsc_extend_settings_customWidgets" name="ts_vcsc_extend_settings_customWidgets" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customWidgets); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customWidgets == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customWidgets == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_customWidgets">Enable "VC Widgets" Post Type <span class="ts-vcsc-element-count">(<?php echo $Post_Widget; ?>)</span></label>			
				</div>
				<div class="ts-vcsc-info-field ts-vcsc-warning" style="margin-top: 20px; font-size: 13px; text-align: justify;">
					In order to actually use Visual Composer elements with this post type, you might have to go to the <a href="<?php echo $visual_composer_link; ?>" target="_parent">settings</a> page ("Role Manager") for Visual Composer itself,
					and assign this new post type to the list of allowable post types that Visual Composer will be available for.
				</div>	
			</div>
		</div>
	<?php } ?>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-settings"></i>Manage Custom Post Type Menu Positions</div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 20px; font-size: 13px; text-align: justify;">
				Provided the associated post types are activated, using the settings above, the plugin will place each custom post type at a pre-determined position in your WordPress admin menu. But if another plugin or your
				theme is claiming the same position for another custom post type, the post type from this plugin might not be visible, as each position can only be used once. In that case, you can use the settings below to
				assign a different position to each custom post type this plugin provides for. <strong>Please ensure, that you assign an unique position to each post type.</strong>
			</div>						
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Position: VC Widgets:</div>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionWidgets" id="ts_vcsc_extend_settings_positionWidgets" class="ts_vcsc_extend_settings_positionWidgets ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Widgets; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionWidgets_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Widgets; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Position: VC Timeline:</div>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionTimeline" id="ts_vcsc_extend_settings_positionTimeline" class="ts_vcsc_extend_settings_positionTimeline ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Timeline; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionTimeline_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Timeline; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Position: VC Team:</div>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionTeam" id="ts_vcsc_extend_settings_positionTeam" class="ts_vcsc_extend_settings_positionTeam ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Team; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionTeam_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Team; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Position: VC Testimonials:</div>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionTestimonials" id="ts_vcsc_extend_settings_positionTestimonials" class="ts_vcsc_extend_settings_positionTestimonials ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Testimonials; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionTestimonials_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Testimonials; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Position: VC Skillsets:</div>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionSkillsets" id="ts_vcsc_extend_settings_positionSkillsets" class="ts_vcsc_extend_settings_positionSkillsets ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Skillsets; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionSkillsets_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Skillsets; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Position: VC Logos:</div>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionLogos" id="ts_vcsc_extend_settings_positionLogos" class="ts_vcsc_extend_settings_positionLogos ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Logos; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionLogos_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Logos; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div style="height: 0px; width: 100%; margin: 0 0 10px 0; padding: 0;"></div>
		</div>
	</div>
</div>