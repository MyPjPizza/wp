<?php
/**
 * Process Feeds Modal
 */
?>
	<div id="feeds_modal_container" style="display:none;">
		<div id="feeds_container">

			<div id="post_tag" class="tagsdiv">
				<div id="process_feeds_options">

					<?php

					if ( empty( $feeds) || ! is_array( $feeds ) ) {
						?>
						<p class="description"><?php esc_html_e( 'You cannot process feeds for these entries because this form does not currently have any feeds configured.', 'gravityplus-gfutility' ); ?></p>

						<?php
					} else {
						?>
						<p class="description"><?php esc_html_e( 'Specify which feeds you would like to process for the selected entries.', 'gravityplus-gfutility' ); ?></p>
						<?php
						foreach ( $feeds as $feed ) {
							?>
							<input type="checkbox" class="gform_feeds" value="<?php echo esc_attr( $feed['id'] ); ?>" id="feed_<?php echo esc_attr( $feed['id'] ); ?>"" />
							<label for="feed_<?php echo esc_attr( $feed['id'] ); ?>"><?php echo esc_html( $addons[ $feed['addon_slug'] ]['title'] ); ?>: <?php echo esc_html( $feed['meta']['feedName'] ); ?></label>
							<br /><br />
							<?php
						}

						?>

						<input type="button" name="feed_process" id="feed_process" value="<?php esc_attr_e( 'Process Feeds', 'gravityplus-gfutility' ) ?>" class="button" style="" onclick="BulkProcessFeeds();" />
						<span id="feeds_please_wait_container" style="display:none; margin-left: 5px;">
                                                <i class='gficon-gravityforms-spinner-icon gficon-spin'></i> <?php esc_html_e( 'Processing...', 'gravityplus-gfutility' ); ?>
                                            </span>
						<?php
					}
					?>

				</div>

				<div id="process_feeds_close" style="display:none;margin:10px 0 0;">
					<input type="button" name="process_feeds_close_button" value="<?php esc_attr_e( 'Close Window', 'gravityplus-gfutility' ) ?>" class="button" style="" onclick="closeModal(true);" />
				</div>

			</div>

		</div>
	</div>