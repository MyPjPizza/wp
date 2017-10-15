<?php $popup_id = function_exists( 'get_the_popup_ID' ) ? get_the_popup_ID() : get_the_ID(); ?>
<div class="popmake-tcp-box"<?php echo $height ? 'style="height: ' . intval( $height ) . 'px;"' : ''; ?>>
	<?php echo apply_filters( 'popmake_terms_conditions', $content, $popup_id ); ?>
</div>
<?php if( popmake_get_popup_terms_conditions( $popup_id, 'force_read' ) ) : ?>
<p class="popmake-tcp-read-notice"><?php echo popmake_get_popup_terms_conditions( $popup_id, 'force_read_notice' ); ?></p>
<?php endif; ?>
<div class="popmake-tcp-agree">
	<div class="popmake-tcp-checkbox-container <?php echo popmake_get_popup_terms_conditions( $popup_id, 'checkbox_style' ); ?>">
		<input type="checkbox" id="popmake-tcp-<?php echo $popup_id; ?>" class="popmake-tcp-input" />
		<label for="popmake-tcp-<?php echo $popup_id; ?>" class="popmake-tcp-checkbox"></label>
	</div>
	<label for="popmake-tcp-<?php echo $popup_id; ?>"><?php echo popmake_get_popup_terms_conditions( $popup_id, 'agree_text' ); ?></label>
</div>