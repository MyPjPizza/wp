<?php

// =============================================================================
// EMAIL-GETRESPONSE/VIEWS/ADMIN/METABOX-LISTS.PHP
// -----------------------------------------------------------------------------
// Provider email lists.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Metabox
// =============================================================================

// Metabox
// =============================================================================

?>

<p><?php _e( 'Below are the campaigns available from your account.', '__x__' ); ?></p>

<table class="form-table">

  <tr>
    <th>
      <label for="<?php echo $plugin_slug . '_gr_list_cache'; ?>">
        <strong><?php _e( 'Campaigns', '__x__' ); ?></strong>
        <span><?php _e( 'If you have added a new campaign or custom field to your account, click the "Refresh" button to see it listed here.', '__x__' ); ?></span>
      </label>
    </th>
    <td>
      <select multiple disabled>
        <?php if ( empty( $gr_list_cache ) ) : ?>
          <option><?php _e( 'No lists found', '__x__' ); ?></option>
        <?php else : ?>
          <?php foreach ( $gr_list_cache as $item ) : ?>
            <option><?php echo $item['name']; ?></option>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
      <br>
      <br>
      <a href="<?php echo $gr_list_refresh_url; ?>" class="button"><?php _e( 'Refresh', '__x__' ); ?></a>
    </td>
  </tr>

</table>
