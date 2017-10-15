<?php
	global $VISUAL_COMPOSER_EXTENSIONS;

?>

<div id="ts-settings-other" class="tab-content">
	<?php if ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_additions', 1) == 1)) || (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginExtended == "false"))) { ?>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-schedule"></i>Extended Rows & Columns</div>
			<div class="ts-vcsc-section-content">
				<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					Visual Composer Extensions allows you to extend the available options for Row and Column settings, adding features such as viewport animations (row + column) and a variety of background effects (row). If you already use other
					plugins that provide the same or similar options you should decide for either one but not use both at the same time as they can cause contradicting settings. Also, if your theme incorporates Visual Composer by itself, some
					themes already provide you with similar options; in these cases, you should disable the settings below in order to avoid any conflicts.
				</div>		
				<div style="margin-top: 20px; font-weight: bold;">The extended Row and Column Options require a Visual Composer version of 4.1 or higher, in order to function correctly!</div>		
				<div style="margin-top: 20px;">
					<div style="font-weight: bold; font-size: 14px; margin: 0;">Extend Options for Visual Composer Rows:</div>
					<p style="font-size: 12px;">Extend Row Options with Background Effects and Viewport Animation Settings:</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_additionsRows == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_additionsRows" class="toggle-check ts_vcsc_extend_settings_additionsRows" name="ts_vcsc_extend_settings_additionsRows" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_additionsRows); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_additionsRows == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_additionsRows == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_additionsRows">Extend Row Options</label>
				</div>				
				<div id="ts_vcsc_extend_settings_additionsRows_true" style="margin-top: 20px; margin-bottom: 10px; margin-left: 25px; <?php echo ($ts_vcsc_extend_settings_additionsRows == 0 ? 'display: none;' : 'display: block;'); ?>">
					<h4>Enable Padding/Margin Options:</h4>
					<p style="font-size: 12px;">When a row background has been applied with the extended row options, a background indicator can be shown next to the row control options:</p>
					<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
						Up until version 4.0.0 of this add-on, the extended row options also included settings to define a top/bottom padding to the row and left/right margins to the background style. Due to the historic names of the setting
						parameters, conflicts with some themes could occur that used the same names for their custom setting options for rows. In order to avoid such problems, the padding and margin options have been disabled by
						default but can easily be re-enabled using the setting below. If you notice any conflicts or layout issues with the option enabled, you should keep it disabled.
					</div>	
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_additionsOffsets == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_additionsOffsets" class="toggle-check ts_vcsc_extend_settings_additionsOffsets" name="ts_vcsc_extend_settings_additionsOffsets" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_additionsOffsets); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_additionsOffsets == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_additionsOffsets == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_additionsRows">Enable Padding/Margin Options</label>	
					<div style="margin-top: 20px;">
						<h4>Show Background Preview Indicator:</h4>
						<p style="font-size: 12px;">When a row background has been applied with the extended row options, a background indicator can be shown next to the row control options:</p>
						<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_backgroundIndicator == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
							<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_backgroundIndicator" class="toggle-check ts_vcsc_extend_settings_backgroundIndicator" name="ts_vcsc_extend_settings_backgroundIndicator" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_backgroundIndicator); ?>/>
							<div class="toggle toggle-light" style="width: 80px; height: 20px;">
								<div class="toggle-slide">
									<div class="toggle-inner">
										<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_backgroundIndicator == 1 ? 'active' : ''); ?>">Yes</div>
										<div class="toggle-blob"></div>
										<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_backgroundIndicator == 0 ? 'active' : ''); ?>">No</div>
									</div>
								</div>
							</div>
						</div>
						<label class="labelToggleBox" for="ts_vcsc_extend_settings_additionsRows">Show Background Indicator</label>
					</div>
					<div style="margin-top: 20px;">
						<h4>Define Breakpoint for Row Backgrounds:</h4>
						<p style="font-size: 12px;">Define the breakpoint (based on row width) to determine if a row background should be used or not:</p>						
						<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
							This plugin provides a variety of background effects that can be applied to rows. Those background effects are automatically removed on mobile devices but you can also define a breakpoint, based on
							row width, that is used on desktop devices to determine when a background effect should be disabled. When a row width falls below the defined breakpoint, the background effect applied to that row will
							be disabled automatically.
						</div>						
						<div class="ts-nouislider-input-slider clearFixMe" style="margin-bottom: 20px; width: 100%; float: left;">
							<h4>Activate Background Effects for Rows larger than:</h4>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_additionsRowEffectsBreak" id="ts_vcsc_extend_settings_additionsRowEffectsBreak" class="ts_vcsc_extend_settings_additionsRowEffectsBreak ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="0" max="4096" step="1" value="<?php echo $ts_vcsc_extend_settings_additionsRowEffectsBreak; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_additionsRowEffectsBreak_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $ts_vcsc_extend_settings_additionsRowEffectsBreak; ?>" data-min="0" data-max="4096" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
					</div>					
					<div style="margin-top: 20px;">
						<h4>Row Visibility Limits:</h4>
						<p style="font-size: 12px;">Define the minimum screen size limits to be used for the row visibility control settings within the extended row options:</p>						
						<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
							As the row shortcode is actually defined and handled by Visual Composer itself and due to the way Visual Composer allows add-ons to extend row options, it is NOT possible to apply the row visibility
							check server side, but only via JS function (client side).
						</div>						
						<div class="ts-nouislider-input-slider clearFixMe" style="margin-bottom: 20px; width: 100%; float: left;">
							<h4>Large Screen Devices:</h4>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_rowLimitLarge" id="ts_vcsc_extend_settings_rowLimitLarge" class="ts_vcsc_extend_settings_rowLimitLarge ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="<?php echo $TS_VCSC_Row_Visibility_Limits['Medium Devices']; ?>" max="4096" step="1" value="<?php echo $TS_VCSC_Row_Visibility_Limits['Large Devices']; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_rowLimitLarge_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $TS_VCSC_Row_Visibility_Limits['Large Devices']; ?>" data-min="<?php echo $TS_VCSC_Row_Visibility_Limits['Medium Devices']; ?>" data-max="4096" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
						<div class="ts-nouislider-input-slider clearFixMe" style="margin-bottom: 20px; width: 100%; float: left;">
							<h4>Medium Screen Devices:</h4>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_rowLimitMedium" id="ts_vcsc_extend_settings_rowLimitMedium" class="ts_vcsc_extend_settings_rowLimitMedium ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="<?php echo $TS_VCSC_Row_Visibility_Limits['Small Devices']; ?>" max="<?php echo $TS_VCSC_Row_Visibility_Limits['Large Devices']; ?>" step="1" value="<?php echo $TS_VCSC_Row_Visibility_Limits['Medium Devices']; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_rowLimitMedium_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $TS_VCSC_Row_Visibility_Limits['Medium Devices']; ?>" data-min="<?php echo $TS_VCSC_Row_Visibility_Limits['Small Devices']; ?>" data-max="<?php echo $TS_VCSC_Row_Visibility_Limits['Large Devices']; ?>" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
						<div class="ts-nouislider-input-slider clearFixMe" style="margin-bottom: 20px; width: 100%; float: left;">
							<h4>Small Screen Devices:</h4>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_rowLimitSmall" id="ts_vcsc_extend_settings_rowLimitSmall" class="ts_vcsc_extend_settings_rowLimitSmall ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="0" max="<?php echo $TS_VCSC_Row_Visibility_Limits['Medium Devices']; ?>" step="1" value="<?php echo $TS_VCSC_Row_Visibility_Limits['Small Devices']; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_rowLimitSmall_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $TS_VCSC_Row_Visibility_Limits['Small Devices']; ?>" data-min="0" data-max="<?php echo $TS_VCSC_Row_Visibility_Limits['Medium Devices']; ?>" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
						<h4>Extra Small Screen Devices:</h4>
						<p style="font-size: 12px;">All devices with a screen resolution of less than the minimum resolution defined for "Small Screen Devices" will automatically be treated as "Extra Small Screen Devices".</p>
					</div>
				</div>
				<div style="margin-top: 20px;">
					<div style="font-weight: bold; font-size: 14px; margin: 0;">Extend Options for Visual Composer Columns:</div>
					<p style="font-size: 12px;">Extend Column Options with Viewport Animation & Equal Height Settings:</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_additionsColumns == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_additionsColumns" class="toggle-check ts_vcsc_extend_settings_additionsColumns" name="ts_vcsc_extend_settings_additionsColumns" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_additionsColumns); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_additionsColumns == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_additionsColumns == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_additionsColumns">Extend Column Options</label>
				</div>		
			</div>
		</div>
	<?php } ?>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-menu"></i>Single Page Navigator Builder <span class="ts-vcsc-element-count">(<i class="dashicons-image-filter"></i> <?php echo ($Extra_Navigator); ?>)</span></div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				This plugin includes dedicated elements to quickly and easily build navigation bars for a single site, linking rows or any other elements with an ID to a specific menu item, therefore allowing your users to quickly
				navigate a single, but large page. If you do not require such a feature, or your theme or another plugin is already providing a similar one for you, you can disable it here.
			</div>
			<div style="margin-top: 10px; margin-bottom: 10px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">Single Page Navigator Builder:</div>
				<p style="font-size: 12px;">Enable or disable the use of the Single Page Navigator elements:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_allowPageNavigator == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_allowPageNavigator" class="toggle-check ts_vcsc_extend_settings_allowPageNavigator" name="ts_vcsc_extend_settings_allowPageNavigator" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_allowPageNavigator); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_allowPageNavigator == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_allowPageNavigator == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_allowPageNavigator">Enable Single Page Navigator Builder Elements <span class="ts-vcsc-element-count">(<?php echo $Extra_Navigator; ?>)</span></label>
			</div>
		</div>
	</div>	
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-editor-code"></i>EnlighterJS - Syntax Highlighter <span class="ts-vcsc-element-count">(<i class="dashicons-image-filter"></i> <?php echo ($Extra_Enlighter); ?>)</span></div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				This plugin includes dedicated elements to quickly and easily highlight code in a variety of programming languages, using multiple available themes. While very useful and important for a variety of uses, it is not
				a feature that every user requires, which is why you can easily enable or disable it, based on your needs.
			</div>
			<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				When enabled and a matching element has been embedded on a page and post, this plugin will load the MooTools library, in addition to the standard jQuery library that WordPress is already loading. Please ensure that
				your theme and other plugins properly enclose and define their jQuery routines in order to prevent any conflicts between both libraries; MooTools will be used in its no-conflict mode.
			</div>
			<div style="margin-top: 10px; margin-bottom: 10px;">
				<div style="font-weight: bold; font-size: 14px; margin: 0;">EnlighterJS - Syntax Highlighter:</div>
				<p style="font-size: 12px;">Enable or disable the use of the EnlighterJS - Syntax Highlighter elements:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_allowEnlighterJS == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_allowEnlighterJS" class="toggle-check ts_vcsc_extend_settings_allowEnlighterJS" name="ts_vcsc_extend_settings_allowEnlighterJS" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_allowEnlighterJS); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_allowEnlighterJS == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_allowEnlighterJS == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_allowPageNavigator">Enable EnlighterJS - Syntax Highlighter Elements <span class="ts-vcsc-element-count">(<?php echo $Extra_Enlighter; ?>)</span></label>
			</div>
			<div id="ts_vcsc_extend_settings_allowEnlighterJS_true" style="margin-top: 20px; margin-bottom: 10px; margin-left: 25px; <?php echo ($ts_vcsc_extend_settings_allowEnlighterJS == 0 ? 'display: none;' : 'display: block;'); ?>">
				<h4>Enable Custom Theme Editor:</h4>
				<p style="font-size: 12px;">If the included themes for the syntax highlighter are not enough for you, the optional theme builder allows you to customize the theme styling, based on the default "Enlighter" theme:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_allowThemeBuilder == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_allowThemeBuilder" class="toggle-check ts_vcsc_extend_settings_allowThemeBuilder" name="ts_vcsc_extend_settings_allowThemeBuilder" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_allowThemeBuilder); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_allowThemeBuilder == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_allowThemeBuilder == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_allowThemeBuilder">Enable Custom Theme Builder</label>
			</div>
		</div>
	</div>
</div>