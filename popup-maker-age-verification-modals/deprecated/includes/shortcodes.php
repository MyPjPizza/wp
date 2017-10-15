<?php
add_shortcode( 'age_verification', 'popmake_av_age_verification_shortcode');
function popmake_av_age_verification_shortcode( $atts ) {
	global $post;
	$atts = shortcode_atts( array(), $atts );
	$age_verification = popmake_get_popup_age_verification( $post->ID );
	$content = '';
	if( popmake_get_popup_age_verification( $post->ID, 'enabled') ) {
		switch($age_verification['type']) {
			case 'enterexit' :
				$content .= "<div style='text-align:center' class='popmake-age-buttons'>";
					$content .= "<button class='age-enter'>". __( 'Enter', 'popup-maker-age-verification-modals' ) . "</button>";
					$content .= "<button class='age-exit'>". __( 'Exit', 'popup-maker-age-verification-modals' ) . "</button>";
				$content .= "</div>";
				break;
			case 'birthdate' :
				$content .= "<div class='popmake-age-form'>";
					$content .= '<div class="age-month">';
						$content .= '<label>' . __( 'Month', 'popup-maker-age-verification-modals' ) . '</label>';
						$content .= "<select class='age-verify-month'>";
						foreach(range(1, 12) as $month)
						{
							$content .= "<option value='". $month ."'>". $month ."</option>";
						}
						$content .= '</select>';
					$content .= "</div>";
					$content .= '<div class="age-day">';
						$content .= '<label>' . __( 'Day', 'popup-maker-age-verification-modals' ) . '</label>';
						$content .= "<select class='age-verify-day'>";
						foreach(range(1, 31) as $day)
						{
							$content .= "<option value='". $day ."'>". $day ."</option>";
						}
						$content .= '</select>';
					$content .= "</div>";
					$content .= '<div class="age-year">';
						$content .= '<label>' . __( 'Year', 'popup-maker-age-verification-modals' ) . '</label>';
						$content .= "<select class='age-verify-year'>";
						$current_year = date('Y', strtotime('-1 year'));
						foreach(range(1901, date('Y', strtotime('-1 year'))) as $year)
						{
							$content .= "<option value='". $year ."'". ($year == $current_year ? ' selected="selected"' : '') .">". $year ."</option>";
						}
						$content .= '</select>';
					$content .= "</div>";
					$content .= '<div class="age-verify">';
						$content .= "<button>". __( 'Enter', 'popup-maker-age-verification-modals' ) . "</button>";
					$content .= "</div>";
				$content .= "</div>";
				break;
		}
	}
	return $content;
}