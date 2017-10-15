<?php

/**
 * GA Event Label Callback
 *
 * Renders text fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $popmake_options Array of all the POPMAKE Options
 * @return void
 */
function popmake_gaeventlabel_callback( $args ) {
	global $popmake_options;

	if ( isset( $popmake_options[ $args['id'] ] ) ) {
		$value = $popmake_options[ $args['id'] ];
	}
	else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	$max  = isset( $args['max'] ) ? $args['max'] : 999999;
	$min  = isset( $args['min'] ) ? $args['min'] : 0;
	$step = isset( $args['step'] ) ? $args['step'] : 1; ?>
	<table>
		<thead>
			<tr>
				<th style="padding: 8px 0px 0px !important;width:25%;">
					<label for="popmake_settings[<?php echo $args['id'];?>][category]">
						<?php _e( 'Category', 'popup-maker-popup-analytics' );?>
					</label>
				</th>
				<th style="padding: 8px 0px 0px !important;width:25%;">
					<label for="popmake_settings[<?php echo $args['id'];?>][action]">
						<?php _e( 'Action', 'popup-maker-popup-analytics' );?>
					</label>
				</th>
				<th style="padding: 8px 0px 0px !important;width:25%;">
					<label for="popmake_settings[<?php echo $args['id'];?>][label]">
						<?php _e( 'Label', 'popup-maker-popup-analytics' );?>
					</label>
				</th>
				<th style="padding: 8px 0px 0px !important;width:25%;">
					<label for="popmake_settings[<?php echo $args['id'];?>][value]">
						<?php _e( 'Value', 'popup-maker-popup-analytics' );?>
					</label>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="padding:0;">
					<input type="text" style="width:100%;" class="medium-text" id="popmake_settings[<?php echo $args['id'];?>][category]" name="popmake_settings[<?php echo $args['id'];?>][category]" value="<?php esc_attr_e( stripslashes( $value['category'] ) ); ?>"/>
				</td>
				<td style="padding:0;">
					<input type="text" style="width:100%;" class="medium-text" id="popmake_settings[<?php echo $args['id'];?>][action]" name="popmake_settings[<?php echo $args['id'];?>][action]" value="<?php esc_attr_e( stripslashes( $value['action'] ) ); ?>"/>
				</td>
				<td style="padding:0;">
					<input type="text" style="width:100%;" class="medium-text" id="popmake_settings[<?php echo $args['id'];?>][label]" name="popmake_settings[<?php echo $args['id'];?>][label]" value="<?php esc_attr_e( stripslashes( $value['label'] ) ); ?>"/>
				</td>
				<td style="padding:0;">
					<input type="number" style="width:100%;" step="<?php esc_attr_e( $step ); ?>" max="<?php esc_attr_e( $max ); ?>" min="<?php esc_attr_e( $min ); ?>" class="medium-text" id="popmake_settings[<?php echo $args['id'];?>][value]" name="popmake_settings[<?php echo $args['id'];?>][value]" value="<?php esc_attr_e( stripslashes( $value['value'] ) ); ?>"/>
				</td>
			</tr>
		</tbody>
	</table><?php
}

