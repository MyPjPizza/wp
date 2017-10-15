<div id="pum_alm_fields" class="popmake_meta_table_wrap" style="margin: -6px -12px -12px;">

	<div class="pum-tabs-container vertical-tabs tabbed-form">

		<ul class="tabs">
			<li class="tab">
				<a href="#pum_alm_login_settings"><?php _e( 'Login', 'popup-maker-ajax-login-modals' ); ?></a>
			</li>
			<li class="tab">
				<a href="#pum_alm_registration_settings"><?php _e( 'Registration', 'popup-maker-ajax-login-modals' ); ?></a>
			</li>
			<li class="tab">
				<a href="#pum_alm_recovery_settings"><?php _e( 'Recovery', 'popup-maker-ajax-login-modals' ); ?></a>
			</li>
		</ul>

		<div id="pum_alm_login_settings" class="tab-content">
			<table class="form-table">
				<tbody>
				<tr>
					<th scope="row"><?php _e( 'Enable AJAX Login Modals', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[login][enabled]" id="popup_ajax_login_enabled" <?php checked( $pum_alm['login']['enabled'], 1 ); ?>/>
						<label for="popup_ajax_login_enabled" class="description"><?php _e( 'Checking this will enable login modal functionality.', 'popup-maker-ajax-login-modals' ); ?></label>
					</td>
				</tr>
				<tr class="ajax_login_enabled">
					<th scope="row"><?php _e( 'Force Login', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[login][force_login]" id="popup_ajax_login_force_login" <?php checked( $pum_alm['login']['force_login'], 1 ); ?>/>
						<label for="popup_ajax_login_force_login" class="description"><?php _e( 'Checking this will force users to login before they can close the modal.', 'popup-maker-ajax-login-modals' ); ?></label>
					</td>
				</tr>
				<tr class="ajax_login_enabled">
					<th scope="row"><?php _e( 'Block Action', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[login][action_block]" id="popup_ajax_login_action_block" <?php checked( $pum_alm['login']['action_block'], 1 ); ?>/>
						<label for="popup_ajax_login_action_block" class="description"><?php _e( 'Checking this will force users to login before clicking targeted buttons & links.', 'popup-maker-ajax-login-modals' ); ?></label>
					</td>
				</tr>
				<tr class="ajax_login_enabled">
					<th scope="row"><?php _e( 'Allow Remember User?', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[login][allow_remember]" id="popup_ajax_login_allow_remember" <?php checked( $pum_alm['login']['allow_remember'], 1 ); ?>/>
						<label for="popup_ajax_login_allow_remember" class="description"><?php _e( 'Checking this will allow users to use remember me function.', 'popup-maker-ajax-login-modals' ); ?></label>
					</td>
				</tr>
				<tr class="ajax_login_enabled">
					<th scope="row"><?php _e( 'Disable Redirect after Login', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[login][disable_redirect]" id="popup_ajax_login_disable_redirect" <?php checked( $pum_alm['login']['disable_redirect'], 1 ); ?>/>
						<label for="popup_ajax_login_disable_redirect" class="description"><?php _e( 'Checking this will not refresh the page after login. This may not work for situations, things like admin bar cannot be shown without refresh.', 'popup-maker-ajax-login-modals' ); ?></label>
					</td>
				</tr>
				<tr class="ajax_login_enabled ajax_login_redirect_enabled">
					<th scope="row">
						<label for="popup_ajax_login_redirect_url">
							<?php _e( 'Login Redirect URL', 'popup-maker-ajax-login-modals' ); ?>
						</label>
					</th>
					<td>
						<input type="text" class="regular-text" name="pum_alm[login][redirect_url]" id="popup_ajax_login_redirect_url" value="<?php esc_attr_e( $pum_alm['login']['redirect_url'] ) ?>" />
						<p class="description"><?php _e( 'If you want to redirect to another page after login enter the url here. Leaving blank will keep user on the same page.', 'popup-maker-ajax-login-modals' ) ?></p>
					</td>
				</tr>
				<tr class="ajax_login_enabled">
					<th scope="row">
						<label for="popup_ajax_login_close_delay">
							<?php _e( 'Auto Close Delay', 'popup-maker-ajax-login-modals' ); ?>
						</label>
					</th>
					<td>
						<input type="text" readonly
							value="<?php esc_attr_e( $pum_alm['login']['close_delay'] ) ?>"
							name="pum_alm[login][close_delay]"
							id="popup_ajax_login_close_delay"
							class="popmake-range-manual"
							step="<?php esc_attr_e( apply_filters( 'popmake_popup_ajax_login_close_delay_step', 500 ) ); ?>"
							min="<?php esc_attr_e( apply_filters( 'popmake_popup_ajax_login_close_delay_min', 0 ) ); ?>"
							max="<?php esc_attr_e( apply_filters( 'popmake_popup_ajax_login_close_delay_max', 10000 ) ); ?>"
						/>
						<span class="range-value-unit regular-text">ms</span>
						<p class="description"><?php _e( 'This is the delay before the popup closes & redirect occurs.', 'popup-maker-ajax-login-modals' ) ?></p>
					</td>
				</tr>

				<?php do_action( 'popmake_popup_ajax_login_meta_box_fields', $post->ID ); ?>
				</tbody>
			</table>
		</div>

		<div id="pum_alm_registration_settings" class="tab-content">
			<table class="form-table">
				<tbody>
				<tr>
					<th scope="row"><?php _e( 'Enable Registration Modal', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[registration][enabled]" id="popup_ajax_registration_enabled" <?php checked( $pum_alm['registration']['enabled'], 1 ); ?>/>
						<label for="popup_ajax_registration_enabled" class="description"><?php _e( 'Checking this will enable registration modal functionality.', 'popup-maker-ajax-login-modals' ); ?></label><?php
						$multisite_reg = get_site_option( 'registration' );
						if ( ! ( get_option( 'users_can_register' ) && ! is_multisite() ) && ! ( $multisite_reg == 'all' || $multisite_reg == 'blog' || $multisite_reg == 'user' ) ) { ?>
							<p class="description"><?php _e( 'Site registration is currently closed. This must be enabled for registration modal functionality to work.', 'popup-maker-ajax-login-modals' ); ?></p><?php
						} ?>
					</td>
				</tr>
				<tr class="ajax_registration_enabled">
					<th scope="row"><?php _e( 'User created passwords?', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[registration][enable_password]" id="popup_ajax_registration_enable_password" <?php checked( $pum_alm['registration']['enable_password'], 1 ); ?>/>
						<label for="popup_ajax_registration_enable_password" class="description"><?php _e( 'Checking this will allow the user to enter their own password. Otherwise it will create and send them a unique password.', 'popup-maker-ajax-login-modals' ); ?></label>
					</td>
				</tr>
				<tr class="ajax_registration_enabled">
					<th scope="row"><?php _e( 'Login After Registration?', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[registration][enable_autologin]" id="popup_ajax_registration_enable_autologin" <?php checked( $pum_alm['registration']['enable_autologin'], 1 ); ?>/>
						<label for="popup_ajax_registration_enable_autologin" class="description"><?php _e( 'Checking this will log the user in automatically after registration.', 'popup-maker-ajax-login-modals' ); ?></label>
					</td>
				</tr>
				<tr class="ajax_registration_enabled">
					<th scope="row"><?php _e( 'Disable Redirect after Regitration', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[registration][disable_redirect]" id="popup_ajax_registration_disable_redirect" <?php checked( $pum_alm['registration']['disable_redirect'], 1 ); ?>/>
						<label for="popup_ajax_registration_disable_redirect" class="description"><?php _e( 'Checking this will not refresh the page after registration. This may not work for situations, things like admin bar cannot be shown without refresh.', 'popup-maker-ajax-login-modals' ); ?></label>
					</td>
				</tr>
				<tr class="ajax_registration_enabled ajax_registration_redirect_enabled">
					<th scope="row">
						<label for="popup_ajax_registration_redirect_url">
							<?php _e( 'Registration Redirect URL', 'popup-maker-ajax-login-modals' ); ?>
						</label>
					</th>
					<td>
						<input type="text" class="regular-text" name="pum_alm[registration][redirect_url]" id="popup_ajax_registration_redirect_url" value="<?php esc_attr_e( $pum_alm['registration']['redirect_url'] ) ?>" />
						<p class="description"><?php _e( 'If you want to redirect to another page after registration enter the url here. Leaving blank will keep user on the same page.', 'popup-maker-ajax-login-modals' ) ?></p>
					</td>
				</tr>
				<tr class="ajax_registration_enabled">
					<th scope="row">
						<label for="popup_ajax_registration_close_delay">
							<?php _e( 'Auto Close Delay', 'popup-maker-ajax-login-modals' ); ?>
						</label>
					</th>
					<td>
						<input type="text" readonly
							value="<?php esc_attr_e( $pum_alm['registration']['close_delay'] ) ?>"
							name="pum_alm[registration][close_delay]"
							id="popup_ajax_registration_close_delay"
							class="popmake-range-manual"
							step="<?php esc_attr_e( apply_filters( 'popmake_popup_ajax_registration_close_delay_step', 500 ) ); ?>"
							min="<?php esc_attr_e( apply_filters( 'popmake_popup_ajax_registration_close_delay_min', 0 ) ); ?>"
							max="<?php esc_attr_e( apply_filters( 'popmake_popup_ajax_registration_close_delay_max', 10000 ) ); ?>"
						/>
						<span class="range-value-unit regular-text">ms</span>
						<p class="description"><?php _e( 'This is the delay before the popup closes & redirect occurs.', 'popup-maker-ajax-login-modals' ) ?></p>
					</td>
				</tr>
				<?php do_action( 'popmake_popup_ajax_registration_meta_box_fields', $post->ID ); ?>
				</tbody>
			</table>
		</div>

		<div id="pum_alm_recovery_settings" class="tab-content">
			<table class="form-table">
				<tbody>
				<tr>
					<th scope="row"><?php _e( 'Enable Password Recovery Modal', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[recovery][enabled]" id="popup_ajax_recovery_enabled" <?php checked( $pum_alm['recovery']['enabled'], 1 ); ?>/>
						<label for="popup_ajax_recovery_enabled" class="description"><?php _e( 'Checking this will enable password recovery modal functionality.', 'popup-maker-ajax-login-modals' ); ?></label>
					</td>
				</tr>
				<tr class="ajax_recovery_enabled">
					<th scope="row"><?php _e( 'Disable Redirect after Recovery', 'popup-maker-ajax-login-modals' ); ?></th>
					<td>
						<input type="checkbox" value="1" name="pum_alm[recovery][disable_redirect]" id="popup_ajax_recovery_disable_redirect" <?php checked( $pum_alm['recovery']['disable_redirect'], 1 ); ?>/>
						<label for="popup_ajax_recovery_disable_redirect" class="description"><?php _e( 'Checking this will not refresh the page after recovery. This may not work for situations, things like admin bar cannot be shown without refresh.', 'popup-maker-ajax-login-modals' ); ?></label>
					</td>
				</tr>
				<tr class="ajax_recovery_enabled ajax_recovery_redirect_enabled">
					<th scope="row">
						<label for="popup_ajax_recovery_redirect_url">
							<?php _e( 'Recovery Redirect URL', 'popup-maker-ajax-login-modals' ); ?>
						</label>
					</th>
					<td>
						<input type="text" class="regular-text" name="pum_alm[recovery][redirect_url]" id="popup_ajax_recovery_redirect_url" value="<?php esc_attr_e( $pum_alm['recovery']['redirect_url'] ) ?>" />
						<p class="description"><?php _e( 'If you want to redirect to another page after password recovery enter the url here. Leaving blank will keep user on the same page.', 'popup-maker-ajax-login-modals' ) ?></p>
					</td>
				</tr>
				<tr class="ajax_recovery_enabled">
					<th scope="row">
						<label for="popup_ajax_recovery_close_delay">
							<?php _e( 'Auto Close Delay', 'popup-maker-ajax-login-modals' ); ?>
						</label>
					</th>
					<td>
						<input type="text" readonly
							value="<?php esc_attr_e( $pum_alm['recovery']['close_delay'] ) ?>"
							name="pum_alm[recovery][close_delay]"
							id="popup_ajax_recovery_close_delay"
							class="popmake-range-manual"
							step="<?php esc_attr_e( apply_filters( 'popmake_popup_ajax_recovery_close_delay_step', 500 ) ); ?>"
							min="<?php esc_attr_e( apply_filters( 'popmake_popup_ajax_recovery_close_delay_min', 0 ) ); ?>"
							max="<?php esc_attr_e( apply_filters( 'popmake_popup_ajax_recovery_close_delay_max', 10000 ) ); ?>"
						/>
						<span class="range-value-unit regular-text">ms</span>
						<p class="description"><?php _e( 'This is the delay before the popup closes & redirect occurs.', 'popup-maker-ajax-login-modals' ) ?></p>
					</td>
				</tr>

				<?php do_action( 'popmake_popup_ajax_recovery_meta_box_fields', $post->ID ); ?>
				</tbody>
			</table>
		</div>

	</div>

</div>