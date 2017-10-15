<?php
 
function popmake_siul_get_the_popup_data_attr( $data_attr, $popup_id ) {
	if(popmake_get_popup_secure_logout( $popup_id, 'enabled' )) {
		$data_attr['meta']['secure_logout'] = popmake_get_popup_secure_logout( $popup_id );	
	}
	return $data_attr;
}
add_filter('popmake_get_the_popup_data_attr', 'popmake_siul_get_the_popup_data_attr', 10, 2 );


function popmake_siul_popup_content_filter( $content ) {
	global $post;
	if ($post->post_type == 'popup' && popmake_get_popup_secure_logout( $post->ID, 'enabled' ) && !has_shortcode( $content, 'secure_logout' )) {
		$content .= '[secure_logout]';
	}
	return $content;
}
add_filter('the_popup_content', 'popmake_siul_popup_content_filter', 10);