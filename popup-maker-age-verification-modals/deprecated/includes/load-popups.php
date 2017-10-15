<?php
 
function popmake_av_get_the_popup_data_attr( $data_attr, $popup_id ) {
	if(popmake_get_popup_age_verification( $popup_id, 'enabled' )) {
		$data_attr['meta']['age_verification'] = popmake_get_popup_age_verification( $popup_id );	
	}
	return $data_attr;
}
add_filter('popmake_get_the_popup_data_attr', 'popmake_av_get_the_popup_data_attr', 10, 2 );


function popmake_av_popup_content_filter( $content ) {
	global $post;
	if ($post->post_type == 'popup' && popmake_get_popup_age_verification( $post->ID, 'enabled' ) && !has_shortcode( $content, 'age_verification' )) {
		$content .= '[age_verification]';
	}
	return $content;
}
add_filter('the_popup_content', 'popmake_av_popup_content_filter', 10);